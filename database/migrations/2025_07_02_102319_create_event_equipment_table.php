<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_equipment', function (Blueprint $table) {
             $table->id(); 
            $table->unsignedBigInteger('event_id');
            $table->text('camera_accessories')->nullable(); 
            $table->text('sound_system')->nullable();
            $table->text('lighting')->nullable(); 
            $table->text('av_equipment')->nullable();
            $table->text('additional_requirements')->nullable();
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
        Schema::dropIfExists('event_equipment');
    }
}
