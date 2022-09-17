<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groundwater_level_pointers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('location_id');
            $table->enum('value', [1, 2, 3]);
            $table->string('level')->nullable();
            $table->unsignedDecimal('area')->nullable();
            $table->date('formed_at')->nullable();
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
        Schema::dropIfExists('groundwater_level_pointers');
    }
};
