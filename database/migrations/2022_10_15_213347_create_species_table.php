<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Generation;
use App\Models\Habitat;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Generation::class)->nullable();
            $table->foreignIdFor(Habitat::class)->nullable();
            $table->string('name')->unique();
            $table->integer('capture_rate');
            $table->boolean('is_legendary');
            $table->boolean('is_mythical');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('species');
    }
};
