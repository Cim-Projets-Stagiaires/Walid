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
         // Check and drop soft deletes from the users table
         if (Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Check and drop soft deletes from the demande_de_stages table
        if (Schema::hasColumn('demande_de_stages', 'deleted_at')) {
            Schema::table('demande_de_stages', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Check and drop soft deletes from the rapports table
        if (Schema::hasColumn('rapports', 'deleted_at')) {
            Schema::table('rapports', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add soft deletes back to the users table
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes back to the demande_de_stages table
        Schema::table('demande_de_stages', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes back to the rapports table
        Schema::table('rapports', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
