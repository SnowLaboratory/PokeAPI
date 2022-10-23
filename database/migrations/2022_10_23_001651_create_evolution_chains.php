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
            $table->foreignIdFor(Species::class)->nullable();
            $table->foreignIdFor(EvolutionChain::class, 'evolveTo')->nullable();
            $table->foreignIdFor(EvolutionChain::class, 'evolveFrom')->nullable();
            // $table->foreignIdFor(Item::class)->nullable();
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
