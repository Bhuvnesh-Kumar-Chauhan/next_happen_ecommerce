<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->integer('capacity');
            $table->boolean('indoor')->default(false);
            $table->boolean('outdoor')->default(false);
            $table->boolean('air_conditioned')->default(false);
            $table->boolean('parking_available')->default(false);
            $table->boolean('stage_available')->default(false);
            $table->boolean('audio_system_included')->default(false);
            $table->boolean('video_system_included')->default(false);
            $table->boolean('catering_services')->default(false);
            $table->string('venue_type')->nullable();
            $table->string('seating_style')->nullable();
            $table->string('booking_hours')->nullable();
            $table->decimal('pricing_per_hour', 10, 2)->nullable();
            $table->json('photos')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->json('amenities')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('venues');
    }
}
