<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->nullable()->onCascade('delete');
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->nullable()->onCascade('delete');
            $table->foreign('user_id')->references('id')->on('users')->nullable()->onCascade('delete');
            $table->foreign('admin_id')->references('id')->on('users')->nullable()->onCascade('delete');
        });

        Schema::table('user_badges', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullable()->onCascade('delete');
            $table->foreign('badge_id')->references('id')->on('badges')->nullable()->onCascade('delete');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullable()->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('badges', function (Blueprint $table) {
            $table->dropforeign('department_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropforeign('department_id');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropforeign('department_id');
            $table->dropforeign('user_code');
            $table->dropforeign('admin_id');
        });
        Schema::table('user_badges', function (Blueprint $table) {
            $table->dropforeign('user_code');
            $table->dropforeign('badge_id');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropforeign('user_code');
        });
    }
};
