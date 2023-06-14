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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code');
            $table->string('name')->fulltext();
            $table->integer('qty');
            $table->decimal('price', 10,2);
            $table->decimal('subtotal', 10,2);
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
        Schema::dropIfExists('invoice_items');
    }
};
