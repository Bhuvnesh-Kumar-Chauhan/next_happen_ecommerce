<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable(); 
            $table->boolean('social_media_campaigns')->default(false);
            $table->boolean('influencer_shoutouts')->default(false);
            $table->boolean('email_campaigns')->default(false);
            $table->boolean('whatsapp_promotions')->default(false);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('marketing_services');
    }
}
