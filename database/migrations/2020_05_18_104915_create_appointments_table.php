<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')->references('id')->on('doctor_schedules')->onDelete('cascade');
            $table->string('patient_symptoms')->nullable();
            $table->string('patient_type');
            $table->string('room_id');
            $table->string('prescribe_medicines')->nullable();
            $table->string('spent_hour')->nullable();
            $table->string('investigation')->nullable();
            $table->string('cc')->nullable();
            $table->string('diagonosis')->nullable();
            $table -> integer('isbooked')->default(0);
            $table -> integer('isServiced')->default(0);
            $table -> integer('virtualSessionStatus')->comment('0 = missed,1 = complete,2 = incomplete,3 = interrupt, 4 = manual')->nullable();
            $table -> integer('isCancelled')->default(0);
            $table -> integer('isScheduled')->default(0);
            $table -> integer('isApproved')->default(0);
            $table -> integer('approvedBy')->default(0);
            $table->date('visit_date', 20);
            $table->date('follow_up_visit_date', 20)->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
