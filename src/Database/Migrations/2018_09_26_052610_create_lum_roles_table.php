<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLumRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lum_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('display_name')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->enum('is_active', array('0','1'))->nullable()->default('1');
            $table->integer('created_by')->unsigned()->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name','deleted_at'], 'roles_name_unique', 'BTREE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lum_roles');
    }
}
