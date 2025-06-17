<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('Social Influencer');
            $table->string('audience'); // Bollywood / Regional / Business
            $table->string('platform'); // Instagram / YouTube etc.
            $table->unsignedBigInteger('followers_count')->default(0);
            $table->string('rate_card')->nullable(); // file path or pricing string
            $table->unsignedBigInteger('service_id')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('influencers');
    }
}
