<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLumUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lum_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('name', 255)->nullable()->default(null);
            $table->string('last_name', 255)->nullable()->default(null);
            $table->string('father_name', 255)->nullable()->default(null);
            $table->string('mobile', 20)->nullable()->default(null);
            $table->string('email');
            $table->text('address')->nullable()->default(null);
            $table->text('email_confirmation_code')->nullable()->default(null);
            $table->enum('email_confirmed', array('0','1'))->nullable()->default('0');
            $table->string('password', 255);
            $table->enum('is_active', array('0','1'))->nullable()->default('1');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['username','deleted_at'], 'users_username_unique', 'BTREE');
            $table->unique(['email','deleted_at'], 'users_email_unique', 'BTREE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lum_users');
    }
}