<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountManagerActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_manager_actions', function (Blueprint $table) {
            $table->id();
            $table->enum('action_type',['index','create','store','edit','update','delete']);
            $table->string('actionable_type');
            $table->unsignedBigInteger('actionable_id');
            $table->longText('data')->nullable();
            $table->unsignedBigInteger('log_id');
            $table->foreign('log_id')->references('id')->on('account_manager_logs');
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
        Schema::dropIfExists('account_manager_actions');
    }
}
