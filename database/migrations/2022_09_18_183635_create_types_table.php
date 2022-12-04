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

            // do not delete, used for admin features!
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pokemon_type', function (Blueprint $table) {
            $table->foreignIdFor(Pokemon::class);
            $table->foreignIdFor(Type::class);

            // do not delete, used for admin features!
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('damage_relation', function (Blueprint $table) {
            $table->foreignIdFor(Type::class, 'attacking_type_id');
            $table->foreignIdFor(Type::class, 'defending_type_id');
            $table->unsignedFloat('multiplier');

            // do not delete, used for admin features!
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('damage_relation');
    }
};
