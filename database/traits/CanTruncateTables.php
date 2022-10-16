<?php

namespace Database\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait CanTruncateTables {

    use CanAcceptParameters;

    private function ignoreConstraints(callable $callback) {
        Schema::disableForeignKeyConstraints();
        $callback();
        Schema::enableForeignKeyConstraints();
    }

    public function truncate(array $tables) {
        $tables = collect($tables);
        $nameOutput = $tables->map(fn($name) => " - " . $name)->join("\n");
        $allowedToTruncate = optional($this->parameters)->truncate || $this->command->confirm("You are about to truncate the following tables:\n". $nameOutput. "\n\nDo you want to truncate?");
        if ($allowedToTruncate) {
            $this->command->getOutput()->write("  Truncating...  ");
            $this->forceTruncate($tables->toArray());
            $this->command->info("[DONE]");
        } else {
            $this->command->warn('Skipping truncate');
        }
        return $allowedToTruncate;
    }

    public function forceTruncate(array $tables) {
        $this->ignoreConstraints(function () use ($tables) {
            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }
        });
    }
}
