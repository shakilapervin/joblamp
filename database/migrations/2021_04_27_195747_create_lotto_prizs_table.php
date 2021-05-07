<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLottoPrizsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotto_prizs', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_es');
            $table->string('title_fr');
            $table->string('title_de');
            $table->string('title_ro');
            $table->string('title_pt');
            $table->text('details_en');
            $table->text('details_es');
            $table->text('details_fr');
            $table->text('details_de');
            $table->text('details_ro');
            $table->text('details_pt');
            $table->string('status')->default('active');
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
        Schema::dropIfExists('lotto_prizs');
    }
}
