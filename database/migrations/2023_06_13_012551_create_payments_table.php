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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code');
            $table->enum('payment_status', ['paid', 'pending', 'void'])->default('pending');
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('void_at')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();

            $table->foreign('invoice_code')->references('code')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
