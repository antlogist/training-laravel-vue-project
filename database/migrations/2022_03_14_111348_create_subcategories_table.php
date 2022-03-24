<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->string('slug');

            // $table->unsignedBigInteger('category_id')->index()->nullable();
            // $table->foreign('category_id')->references('id')->on('categories')->nullable();
            $table->foreignId('category_id')->constrained()->nullable();

            // $table->unsignedBigInteger('user_id')->index();
            // $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('user_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategories');
    }
}
