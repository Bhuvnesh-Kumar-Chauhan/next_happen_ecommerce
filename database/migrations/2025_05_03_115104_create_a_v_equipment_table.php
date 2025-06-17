<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAVEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('av_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->nullable(); 
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('length', 8, 2)->nullable(); 
            $table->decimal('width', 8, 2)->nullable();  
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('service_id')->nullable();
            $table->timestamps();
        
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_v_equipment');
    }
}
