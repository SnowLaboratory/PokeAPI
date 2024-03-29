<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Trigger;
use App\Models\EvolutionChain;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolution_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Trigger::class)->nullable();
            $table->foreignIdFor(EvolutionChain::class)->nullable();

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
        Schema::dropIfExists('evolution_paths');
    }
};
