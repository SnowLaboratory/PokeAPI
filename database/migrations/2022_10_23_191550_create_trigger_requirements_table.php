<?php

use App\Models\EvolutionPath;
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
        Schema::create('trigger_requirements', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('boolean_value')->nullable();
            $table->integer('number_value')->nullable();
            $table->dateTime('time_value')->nullable();
            $table->foreignIdFor(EvolutionPath::class)->nullable();
            $table->nullableMorphs('model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger_requirements');
    }
};
