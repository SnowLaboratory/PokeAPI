<?php

use App\Models\EvolutionChain;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::create('evolution_chains', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('species_id')->unsigned()->nullable();
            $table->foreign('species_id')->references('id')->on('species');

            $table->bigInteger('evolveTo')->unsigned()->nullable();
            $table->foreign('evolveTo')->references('id')->on('evolution_chains');

            $table->bigInteger('evolveFrom')->unsigned()->nullable();
            $table->foreign('evolveFrom')->references('id')->on('evolution_chains');

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
        Schema::dropIfExists('evolution_chains');
    }
};
