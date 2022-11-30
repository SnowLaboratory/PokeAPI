<?php

use App\Models\Meta;
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
        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('value');
        });

        Schema::create('has_metas', function (Blueprint $table) {
            $table->foreignIdFor(Meta::class);
            $table->morphs('model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metas');
        Schema::dropIfExists('has_metas');
    }
};
