<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Stores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('city')->nullable();
            $table->text('building')->nullable();
            $table->string('area')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->text('domain_link')->nullable();
            $table->enum('status',[0,1])->comment('0=inactive,1=inActive')->default(0);
            $table->softDeletes();
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
        Schema::drop('stores');
    }
}
