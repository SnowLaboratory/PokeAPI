<?php

use App\Models\Pokemon;
use App\Models\Type;
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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('pokemon_type', function (Blueprint $table) {
            $table->foreignIdFor(Pokemon::class);
            $table->foreignIdFor(Type::class);
        });

        Schema::create('damage_relation', function (Blueprint $table) {
            $table->foreignIdFor(Type::class, 'attacking_type_id');
            $table->foreignIdFor(Type::class, 'defending_type_id');
            $table->unsignedFloat('multiplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
        Schema::dropIfExists('pokemon_type');
    }
};
