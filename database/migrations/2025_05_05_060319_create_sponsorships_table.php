<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable(); // foreign key
            $table->string('event_name');
            $table->text('event_description')->nullable();
            $table->string('event_type');
            $table->string('location')->nullable();
            $table->date('event_date')->nullable();
            $table->string('proposal_file')->nullable();
            $table->unsignedBigInteger('matched_sponsor_id')->nullable();
            $table->text('message')->nullable();
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
        Schema::dropIfExists('sponsorships');
    }
}
