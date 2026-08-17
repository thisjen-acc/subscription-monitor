<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionExpiringMail;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckExpiringSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expiring';
    protected $description = 'Check for subscriptions expiring soon and send staged notifications (2 months, 15 days, 2 days).';

    public function handle()
    {
        $this->checkStage(
            months: 2,
            days: null,
            column: 'notified_at',
            label: '2 months'
        );

        $this->checkStage(
            months: null,
            days: 15,
            column: 'notified_15days_at',
            label: '15 days'
        );

        $this->checkStage(
            months: null,
            days: 2,
            column: 'notified_2days_at',
            label: '2 days'
        );
    }

    private function checkStage(?int $months, ?int $days, string $column, string $label)
    {
        $targetDate = $months
            ? Carbon::now()->addMonths($months)->toDateString()
            : Carbon::now()->addDays($days)->toDateString();

        $subscriptions = Subscription::whereDate('end_date', '<=', $targetDate)
            ->whereNull($column)
            ->get();

        foreach ($subscriptions as $subscription) {
            $recipients = $this->getRecipients($subscription);

            Mail::to($recipients)->send(new SubscriptionExpiringMail($subscription, $label));

            $subscription->{$column} = Carbon::now();
            $subscription->save();
        }

        $this->info("{$label} check: Notified {$subscriptions->count()}");
    }

    private function getRecipients(Subscription $subscription): array
    {
        $recipients = [env('MAIL_TO_ADDRESS', 'jenevievepchacon@gmail.com')];

        if (!empty($subscription->client_emails)) {
            $clientEmails = array_map('trim', explode(',', $subscription->client_emails));
            $clientEmails = array_filter($clientEmails, fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
            $recipients = array_merge($recipients, $clientEmails);
        }

        return array_unique($recipients);
    }
}