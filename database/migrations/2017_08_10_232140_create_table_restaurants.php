<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRestaurants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->Text('summary');
            $table->integer('uid');
            $table->float('fund')->default(0);
            $table->float('percentageDonation')->default(0);
            $table->string('address');
            $table->float('longitude')->default(0);
            $table->float('latitude')->default(0);
            $table->string('url');
            $table->string('phone')->default(0);
            $table->text('info');
            $table->float('rating')->default(0);
            $table->integer('star1')->default(0);
            $table->integer('star2')->default(0);
            $table->integer('star3')->default(0);
            $table->integer('star4')->default(0);
            $table->integer('star5')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
