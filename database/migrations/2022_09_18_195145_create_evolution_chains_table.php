<?php

use App\Models\EvolutionDetails;
use App\Models\Pokemon;
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
        Schema::create('evolution_chains', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EvolutionDetails::class);
            $table->foreignIdFor(Pokemon::class, 'evolves_from_id');
            $table->foreignIdFor(Pokemon::class, 'evolves_to_id');
            $table->foreignIdFor(Pokemon::class, 'pokemon_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evolution_chains');

    }
};
