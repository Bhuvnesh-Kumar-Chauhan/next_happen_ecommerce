<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoundEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sound_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
        
            // Attributes for sound equipment
            $table->boolean('mixer')->default(false);
            $table->boolean('woofers')->default(false);
            $table->boolean('line_array')->default(false);
            $table->boolean('monitor_speakers')->default(false);
            $table->boolean('microphones')->default(false);
            $table->boolean('wireless_mics')->default(false);
            $table->boolean('amplifiers')->default(false);
            $table->boolean('equalizers')->default(false);
            $table->string('setup_area_size')->nullable(); // e.g., "10x15 ft"
            
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
        Schema::dropIfExists('sound_equipment');
    }
}
