<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('talents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_category_id')->constrained();
            $table->string('name');
            $table->text('rate');
            $table->string('audience_type');
            $table->boolean('offered_rate');
            $table->boolean('talent_image')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('talents');
    }
}
