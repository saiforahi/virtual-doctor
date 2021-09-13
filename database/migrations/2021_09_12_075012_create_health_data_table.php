<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->nullable();
            $table->foreignId('moderator_id')->constrained('moderators')->nullable();
            $table->string('temp')->nullable();
            $table->string('bp_sys')->nullable();
            $table->string('bp_dia')->nullable();
            $table->string('ox')->nullable();
            $table->string('hr')->nullable();
            $table->string('hs')->nullable();
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
        Schema::dropIfExists('health_data');
    }
}
