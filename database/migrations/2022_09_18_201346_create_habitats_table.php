<?php

use App\Models\Habitat;
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
        Schema::create('habitats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('pokemon_habitats', function (Blueprint $table) {
            $table->foreignIdFor(Pokemon::class);
            $table->foreignIdFor(Habitat::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habitats');
    }
};
