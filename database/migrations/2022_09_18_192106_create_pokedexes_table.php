<?php

use App\Models\Pokedex;
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
        Schema::create('pokedexes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('has_pokedexes', function (Blueprint $table) {
            $table->foreignIdFor(Pokedex::class);
            $table->morphs('model');
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
        Schema::dropIfExists('has_pokedexes');
    }
};
