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
        Schema::table('users', function (Blueprint $table) {
            $table->string('prenom')->after('name');
            $table->string('telephone')->nullable()->after('prenom');
            $table->text('adresse')->nullable()->after('telephone');
            $table->date('date_naissance')->nullable()->after('adresse');
            $table->renameColumn('name', 'nom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nom', 'name');
            $table->dropColumn(['prenom', 'telephone', 'adresse', 'date_naissance']);
        });
    }
};
