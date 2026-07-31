<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'client_name',
        'subscription_name',
        'duration_months',
        'po_number',
        'monthly_cost',
        'start_date',
        'end_date',
        'notified_at',
    ];
}
