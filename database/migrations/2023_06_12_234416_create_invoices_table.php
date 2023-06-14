<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('user_id');
            // $table->string('customer_code');
            $table->string('customer_name');
            $table->timestamp('due_date')->useCurrent();
            $table->decimal('total')->default(0);
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();

            // $table->foreign('customer_code')->references('code')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::statement('
            create fulltext index invoice_fulltext_index
            on invoices(code,customer_name)
            with parser ngram
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
