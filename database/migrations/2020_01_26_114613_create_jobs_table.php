<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_title');
            $table->string('location')->nullable();
            $table->string('industry')->nullable();
            $table->string('seniority')->nullable();
            $table->string('type')->nullable();
            $table->text('quick_pitch')->nullable();
            $table->json('tags')->nullable();
            $table->json('skills')->nullable();
            $table->string('application_email')->nullable();
            $table->json('ownership_values')->nullable();
            $table->json('application_qualities')->nullable();
            $table->string('promo_photo_link')->nullable();
            $table->text('about_the_colleagues')->nullable();
            $table->text('why_this_role')->nullable();
            $table->string('family_photo')->nullable();
            $table->string('application_url')->nullable();
            $table->string('appplication_email')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('jobs');
    }
}
