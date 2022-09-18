<?php

use App\Models\Pokemon;
use App\Models\Weakness;
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
        Schema::create('weaknesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('pokemon_weakness', function (Blueprint $table) {
            $table->foreignIdFor(Pokemon::class);
            $table->foreignIdFor(Weakness::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weaknesses');
    }
};
