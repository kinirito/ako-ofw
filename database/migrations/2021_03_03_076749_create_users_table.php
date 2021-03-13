<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->string('avatar')->default('default_avatar.jpg');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('first_name');
            $table->date('birthdate');
            $table->string('contact');
            $table->string('facebook')->nullable();
            $table->string('agency');
            $table->string('occupation');
            $table->string('address');
            $table->foreignId('country_id')->constrained('countries');
            $table->boolean('is_status_answered')->default(false);
            $table->string('verification_code')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_first_login')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
