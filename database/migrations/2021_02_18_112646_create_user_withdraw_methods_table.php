<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWithdrawMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_withdraw_methods', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('type')->default('bank');
            $table->string('account_holder_name');
            $table->string('account_holder_type');
            $table->string('routing_number');
            $table->string('account_number');
            $table->string('currency');
            $table->string('country');
            $table->text('token')->nullable();
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
        Schema::dropIfExists('user_withdraw_methods');
    }
}
