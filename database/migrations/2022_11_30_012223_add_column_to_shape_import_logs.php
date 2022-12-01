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
        Schema::table('shape_import_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('layer_id');
            $table->string('zipfile_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shape_import_logs', function (Blueprint $table) {
            //
        });
    }
};
