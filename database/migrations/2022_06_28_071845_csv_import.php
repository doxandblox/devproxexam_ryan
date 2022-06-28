<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CSVImport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_import', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->integer('age');
            $table->string('initials',4);
            $table->string('date_of_birth');
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
        Schema::dropIfExists('csv_import');
    }
}
