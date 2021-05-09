<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_es');
            $table->string('name_pt');
            $table->string('name_fr');
            $table->string('name_de');
            $table->string('name_ro');
            $table->text('description_en');
            $table->text('description_es');
            $table->text('description_pt');
            $table->text('description_fr');
            $table->text('description_de');
            $table->text('description_ro');
            $table->string('icon')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('job_categories');
    }
}
