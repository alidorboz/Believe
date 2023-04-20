<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('pid');
            $table->integer('sid');
            $table->string('categoryName');
            $table->string('categoryImage')->nullable();
            $table->float('categoryDiscount');
            $table->text('description');
            $table->string('url');
            $table->string('metaTitle');
            $table->string('metaDescription');
            $table->string('metaKeywords');
            $table->tinyInteger('status');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
