<?php

use App\Models\Region;
use App\Models\Pokedex;
use App\Models\Generation;
// use App\Models\Release;
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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Generation::class)->nullable();
            $table->string('name');
        });

        // Schema::create('region_release', function (Blueprint $table) {
        //     $table->foreignIdFor(Release::class)->nullable();
        //     $table->foreignIdFor(Region::class)->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');

    }
};
