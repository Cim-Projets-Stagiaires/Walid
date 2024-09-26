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
        Schema::create('demande_de_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_stagiaire");
            $table->string("etablissement");
            $table->string("type_de_stage");
            $table->string("modalite_de_stage");
            $table->string("obligation");
            $table->enum('status', ['postulé', 'approuvé', 'refusé'])->default('postulé');
            $table->enum('pole', ['Services transverses', 'Incubation', 'Valorisation']);
            $table->string("objectif_de_stage");
            $table->date("date_de_debut");
            $table->date("date_de_fin");
            $table->string('cv')->nullable(); 
            $table->string('lettre_de_motivation')->nullable(); 
            //foreign keys
            $table->foreign("id_stagiaire")->references("id")->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_de_stage');
    }
};
