<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->default('https://www.forthepeople.com/sites/default/files/theme-assets/ftp/images/attorneys/attorney-profile-placeholder.jpg');
            $table->timestamps();
            $table->rememberToken()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
