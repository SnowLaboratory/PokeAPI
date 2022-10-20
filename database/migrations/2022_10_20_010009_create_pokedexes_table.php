<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Region;
use App\Models\Pokedex;
use App\Models\Species;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokedexes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Region::class)->nullable();
            $table->string('name');
            $table->boolean(('is_main_series'));
        });

        Schema::create('pokedex_species', function (Blueprint $table) {
            $table->foreignIdfor(Pokedex::class)->nullable();
            $table->foreignIdFor(Species::class)->nullable();
            $table->integer('entry_number');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokedexes');
        Schema::dropIfExists('pokdex_species');
    }
};
