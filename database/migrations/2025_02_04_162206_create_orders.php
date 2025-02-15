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
            $table->foreignId('user_id')->constrained();

            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->double('total_amount');
            $table->string('payment_method');
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
