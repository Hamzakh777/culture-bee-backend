<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_img_url')->nullable();
            $table->string('cover_img_url')->nullable();
            $table->text('quick_pitch')->nullable();
            $table->tinyInteger('current_profile_creation_step')->unsigned()->default(1);
            $table->string('location')->nullable();
            $table->string('company_name')->nullable();
            $table->json('skills')->nullable();
            $table->string('industry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
