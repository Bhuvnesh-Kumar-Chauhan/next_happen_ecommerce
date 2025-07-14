<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFabricationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_fabrications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('fabric_type')->nullable(); 
            $table->string('tablecloths')->nullable(); 
            $table->string('drapes_style')->nullable(); 
            $table->string('fabric_color')->nullable(); 
            $table->string('fabric_quantity')->nullable(); 
            $table->string('custom_fabric_image')->nullable(); 
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
        Schema::dropIfExists('event_fabrications');
    }
}
