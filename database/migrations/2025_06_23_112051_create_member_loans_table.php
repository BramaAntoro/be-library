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
        Schema::create('member_loans', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('book_id')->constrained();    
            $table->dateTime('loan_date');
            $table->dateTime('deadlines');
            $table->dateTime('return_date');
            $table->enum('status', ['borrowed', 'late', 'returned', 'damaged'])->default('borrowed');
            $table->integer('fines_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_loans');
    }
};
