<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_es');
            $table->string('name_pt');
            $table->string('name_fr');
            $table->string('name_de');
            $table->string('name_ro');
            $table->string('parent_id');
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
        Schema::dropIfExists('job_sub_categories');
    }
}
