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
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_stagiaire')->constrained('users')->onDelete('cascade'); // Foreign key to the 'users' table
            $table->string('title');
            $table->string('lien'); // Store the file path
            $table->enum('status', ['en attente', 'validé', 'refusé'])->default('en attente'); // Validation status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};
