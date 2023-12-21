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
        Schema::create('accelerograms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_soato');
            $table->enum('accuracy', [90, 95, 98, 99]);
            $table->decimal('t_sec_a', 4, 2, true)->nullable();
            $table->decimal('e_cm_s2', 13, 10)->nullable();
            $table->decimal('n_cm_s2', 13, 10)->nullable();
            $table->decimal('z_cm_s2', 13, 10)->nullable();
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
        Schema::dropIfExists('accelerograms');
    }
};
