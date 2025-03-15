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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();

            $table->enum('status', ['unconfirmed', 'confirmed', 'shipping ', 'delivered', 'completed', 'canceled'])->default('unconfirmed');
            $table->double('total');
            $table->string('payment_method');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded', 'cancel'])->default('unpaid');
            $table->string('address');
            $table->string('fullname'); 
            $table->string('email');
            $table->string('phone_number');
            $table->text('note')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
