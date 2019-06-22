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
            $table->string('first_name', 255)->nullable()->default(null);
            $table->string('last_name', 255)->nullable()->default(null);
            $table->string('father_name', 255)->nullable()->default(null);
            $table->string('email');
            $table->string('password', 255);
            $table->string('mobile', 20)->nullable()->default(null);
            $table->string('melli_code', 255)->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->text('email_confirmation_code')->nullable()->default(null);
            $table->enum('email_confirmed', array('0','1'))->nullable()->default('0');
            $table->text('mobile_confirmation_code')->nullable()->default(null);
            $table->enum('mobile_confirmed', array('0','1'))->nullable()->default('0');
            $table->enum('user_confirmed', array('0','1'))->nullable()->default('1');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE lum_users ADD unique_md5_username CHAR (32) AS (MD5(CONCAT_WS('X',username,deleted_at))) PERSISTENT UNIQUE");
        DB::statement("ALTER TABLE lum_users ADD unique_md5_email CHAR (32) AS (MD5(CONCAT_WS('X',email,deleted_at))) PERSISTENT UNIQUE");
//        DB::statement("ALTER TABLE lum_users ADD unique_md5_email CHAR (32) AS (MD5(CONCAT_WS('X',mobile,deleted_at))) PERSISTENT UNIQUE");
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
