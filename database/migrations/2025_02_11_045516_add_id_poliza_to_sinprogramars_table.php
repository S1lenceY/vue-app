<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sinprogramars', function (Blueprint $table) {
            Schema::table('sinprogramars', function (Blueprint $table) {
                $table->bigInteger('id_poliza')->before('poliza')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sinprogramars', function (Blueprint $table) {
            //
        });
    }
};
