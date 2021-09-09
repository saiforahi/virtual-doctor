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
            $table->BigIncrements('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('image')->nullable();            
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('active_by')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token',100)->nullable();
            $table->rememberToken();
            $table->tinyInteger('is_deleted')->default(0);
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
