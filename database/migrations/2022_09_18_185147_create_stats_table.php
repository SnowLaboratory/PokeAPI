<?php

use App\Models\Stat;
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
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('base_stat');
            $table->integer('effort');

            // do not delete, used for admin features!
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('has_stats', function (Blueprint $table) {
            $table->foreignIdFor(Stat::class);
            $table->morphs('model');

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
        Schema::dropIfExists('stats');
        Schema::dropIfExists('has_stats');
    }
};
