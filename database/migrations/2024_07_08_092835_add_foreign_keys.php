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
        Schema::table('rapports', function (Blueprint $table) {
            $table->unsignedBigInteger('id_stagiaire')->after('id')->nullable();
            $table->foreign('id_stagiaire')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rapports', function (Blueprint $table) {
            $table->dropForeign(['id_stagiaire']);
            $table->dropColumn('id_stagiaire');
        });
    }
};
