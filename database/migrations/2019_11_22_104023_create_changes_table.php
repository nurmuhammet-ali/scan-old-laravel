<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('host_id');
            
            $table->string('title_old')->nullable();
            $table->string('title_new')->nullable();

            $table->string('cms_old')->nullable();
            $table->string('cms_new')->nullable();

            $table->string('http_code_old')->nullable();
            $table->string('http_code_new')->nullable();

            $table->string('server_old')->nullable();
            $table->string('server_new')->nullable();

            $table->string('x_powered_by_old')->nullable();
            $table->string('x_powered_by_new')->nullable();

            $table->timestamps();
        });
    }

    public function change() 
    {
        // 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('changes');
    }
}
