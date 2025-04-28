<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billing_detail_id'); // Foreign key to the billing_details table
            $table->string('gateway_name'); // Name of the payment gateway (e.g., Stripe, PayPal)
            $table->string('gateway_transaction_id'); // Unique transaction ID from the gateway
            $table->decimal('amount', 10, 2); // Amount paid in this transaction
            $table->enum('status', ['success', 'failed', 'pending'])->default('pending'); // Status of the transaction
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('billing_detail_id')->references('id')->on('billing_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
