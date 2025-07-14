<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_service', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('service_id'); // Foreign key reference to venues
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('service_category_id'); 
            $table->text('event_date'); 
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_service');
    }
}
