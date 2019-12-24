<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->integer('vps_number')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('letter_number')->nullable();
            $table->timestamp('letter_at')->nullable();
            $table->string('employer_name')->nullable();
            $table->string('responsible_employee_name')->nullable();
            $table->string('responsible_employee_phone_number')->nullable();
            $table->string('responsible_employee_email')->nullable();
            $table->string('responsible_employee_home_number')->nullable();
            $table->string('responsible_employee_job_number')->nullable();
            $table->timestamp('contract_at')->nullable();
            $table->string('domain_name')->nullable();
            $table->text('plan')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('associated_at')->nullable();
            $table->string('type')->nullable();
            $table->string('number_noted')->nullable();
            $table->text('more')->nullable();
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
        Schema::dropIfExists('hostings');
    }
}
