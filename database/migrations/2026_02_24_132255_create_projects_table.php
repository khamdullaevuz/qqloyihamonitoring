<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('region_id');
            $table->string('act');
            $table->integer('object_count');
            $table->string('responsible_name');
            $table->string('responsible_phone');
            $table->string('customer');
            $table->string('contract_number');
            $table->date('contract_date');
            $table->decimal('total_sum');
            $table->decimal('paid_amount');
            $table->decimal('remaining_amount');
            $table->string('wallbill_number');
            $table->date('walbill_date');
            $table->decimal('invoice_amount');
            $table->decimal('invoice_paid_amount');
            $table->decimal('invoice_debit');
            $table->decimal('invoice_credit');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('comment')->nullable();
            $table->uuid('currency_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
