<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCelebritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('celebrities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id'); // Add this line
            $table->string('name');
            $table->enum('category', ['Actor', 'Singer', 'Reality Star']);
            $table->enum('audience', ['Bollywood', 'Regional', 'Business']);
            $table->decimal('rate_card', 10, 2)->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('celebrities');
    }
}
