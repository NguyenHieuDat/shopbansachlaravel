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
        Schema::create('tbl_book', function (Blueprint $table) {
            $table->Increments('book_id');
            $table->string('book_name');
            $table->integer('category_id');
            $table->integer('author_id');
            $table->integer('publisher_id');
            $table->string('book_image');
            $table->string('book_language');
            $table->integer('book_year');
            $table->integer('book_page');
            $table->string('book_price');
            $table->integer('book_status');
            $table->text('book_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_book');
    }
};
