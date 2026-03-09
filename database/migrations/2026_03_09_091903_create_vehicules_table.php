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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('immatriculation');
            $table->string('marque');
            $table->string('modele');
            $table->string('motorisation');
            $table->int('nb_portes');
            $table->int('nb_places');
            $table->string('type_boite_vitesse');
            $table->decimal('prix_journalier', 7, 2);
            $table->string('image_url');
            $table->int('age_minimum');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
