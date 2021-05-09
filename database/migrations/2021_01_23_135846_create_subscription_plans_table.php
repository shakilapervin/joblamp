<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_es');
            $table->string('title_fr');
            $table->string('title_de');
            $table->string('title_ro');
            $table->string('title_pt');
            $table->text('description_en')->nullable();
            $table->text('description_es')->nullable();
            $table->text('description_de')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_ro')->nullable();
            $table->text('description_pt')->nullable();
            $table->text('duration');
            $table->text('default_price');
            $table->text('number_of_jobs');
            $table->tinyInteger('recommended');
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
        Schema::dropIfExists('subscription_plans');
    }
}
