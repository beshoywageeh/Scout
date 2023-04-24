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
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->string('fourth_name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('home_number', 40)->nullable();
            $table->string('church_father', 50)->nullable();
            $table->boolean('login_allow')->default(0);
            $table->boolean('black_list')->default(0);
            $table->date('join_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->integer('code')->unique();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
