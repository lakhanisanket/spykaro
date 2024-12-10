<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('user_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->string('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
