<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('subscription_name');
            $table->integer('duration_months')->default(1);
            $table->string('po_number')->nullable();
            $table->decimal('monthly_cost', 10, 2)->default(0.00);
            $table->date('start_date');
            $table->date('end_date');
            $table->date('notified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
