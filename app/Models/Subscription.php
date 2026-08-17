<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'client_name',
        'client_emails',
        'subscription_name',
        'duration_months',
        'po_number',
        'kit_number',
        'monthly_cost',
        'start_date',
        'end_date',
        'notified_at',
        'notified_15days_at',
        'notified_2days_at',

    ];
}
