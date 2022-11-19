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
        Schema::create('osr_sections', function (Blueprint $table) {
            $table->id();
            $table->multiPolygon('geom');
            $table->unsignedTinyInteger('soato')->default(17);
            $table->enum('accuracy', [90, 95, 98]);
            $table->string('details')->nullable();
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
        Schema::dropIfExists('osr_sections');
    }
};
