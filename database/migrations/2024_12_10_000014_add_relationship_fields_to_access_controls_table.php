<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAccessControlsTable extends Migration
{
    public function up()
    {
        Schema::table('access_controls', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_10315934')->references('id')->on('users');
            $table->unsignedBigInteger('device_id')->nullable();
            $table->foreign('device_id', 'device_fk_10315935')->references('id')->on('devices');
        });
    }
}
