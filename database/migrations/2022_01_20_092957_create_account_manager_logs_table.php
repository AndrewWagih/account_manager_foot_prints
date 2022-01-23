<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountManagerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_manager_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_manager_id');
            $table->foreign('account_manager_id')->references('id')->on('users');
            $table->integer('vendor_id');
            $table->string('reason_log');
            $table->string('token')->nullable();
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
        Schema::dropIfExists('account_manager_logs');
    }
}
