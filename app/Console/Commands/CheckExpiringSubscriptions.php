<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckExpiringSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expiring';
    protected $description = 'Check for subscriptions that are expiring soon and send notifications.';

    public function handle()
    {
        $targetDate = Carbon::now()->addMonths(2)->toDateString();

        $subscriptions = Subscription::whereDate('end_date', '<=', $targetDate)
            ->whereNull('notified_at')
            ->get();

        foreach ($subscriptions as $subscription) {
            Mail::raw(
                "Subscription for {$subscription->client_name} ({$subscription->subscription_name}) expires on {$subscription->end_date}. PO Number: {$subscription->po_number}. Monthly cost: {$subscription->monthly_cost}.",
                function ($message) use ($subscription) {
                    $message->to(env('MAIL_TO_ADDRESS', 'jenevievepchacon@gmail.com'))
                        ->subject("Subscription Expiring Soon: {$subscription->client_name}");
                }
            );

            $subscription->notified_at = Carbon::now();
            $subscription->save();
        }

        $this->info("Checked subscriptions. Notified: " . $subscriptions->count());
    }
}