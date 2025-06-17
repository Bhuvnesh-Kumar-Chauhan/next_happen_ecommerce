<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFabricationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabrications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->boolean('stage_with_grey_carpet')->default(false);
            $table->boolean('stage_skirting')->default(false);
            $table->boolean('console_masking')->default(false);
            $table->boolean('standees')->default(false);
            $table->boolean('selfie_point')->default(false);
            $table->boolean('digital_podium_with_mic')->default(false);
            $table->boolean('stairs_step')->default(false);
            $table->boolean('side_flex_with_screen')->default(false);
            $table->boolean('main_flex_at_front')->default(false);
            $table->boolean('led_letter_at_front')->default(false);
            $table->float('length_in_feet')->nullable();
            $table->float('width_in_feet')->nullable();
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
        Schema::dropIfExists('fabrications');
    }
}
