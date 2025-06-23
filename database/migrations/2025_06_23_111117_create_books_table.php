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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('author_id')->constrained();
            $table->char('isbn', 13)->unique();
            $table->dateTime("published_year");
            $table->text('description');
            $table->integer('total_copies')->default(0);
            $table->integer('total_borrowed')->default(0);
            $table->integer('total')->default(0);
            $table->string('cover_image_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
