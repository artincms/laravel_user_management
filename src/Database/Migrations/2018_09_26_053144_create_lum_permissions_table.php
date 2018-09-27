<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLumPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lum_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable()->default(0);
            $table->string('name', 255);
            $table->string('display_name')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->enum('is_active', array('0','1'))->nullable()->default('1');
            $table->integer('created_by')->unsigned()->nullable()->default(0);
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
        Schema::dropIfExists('lum_permissions');
    }
}
