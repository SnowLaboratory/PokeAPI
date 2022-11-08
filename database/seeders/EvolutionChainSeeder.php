<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Species;
use App\Models\Trigger;
use Illuminate\Support\Str;
use App\Models\EvolutionPath;

class EvolutionChainSeeder extends Seeder
{
    use CanTruncateTables;
    use CanDisplayProgress;

    public function run()
    {
        $this->truncate([
            'evolution_chains',
        ]);

        // 2. Fetch all the evolution chains from the API
        $api = new EndpointBuilder();

        $url = $api->getAllEvolutionChains() . "?" . http_build_query([
            "limit" => 10000,
        ]);

        $infoJson = fetchJson($url);

        // 3. Loop over a list of urls associated to each url
        $urls = collect($infoJson['results'])->pluck('url');

        $this->progressMap($urls, function($chainUrl) {

            // 4. Fetch all the data for a specific chain
            $chainJson = fetchJson($chainUrl);

            // 5. traverse chain
            $this->traverseChain($chainJson['chain'], $chainJson);

        });
    }

    private function createChainFromSpecies($name) {
        $speciesDB = Species::firstWhere('name', $name);
        return $speciesDB->chain()->create();
    }

    public function traverseChain($currentChainJson, $rootChainJson , $previousChainDB=null, $depth=0) {
        // Create a chain record for current pokemon species.
        $previousChainDB = $previousChainDB ?? $this->createChainFromSpecies($currentChainJson['species']['name']);

        // Only handle the chain when it has evolutions
        foreach ($currentChainJson['evolves_to'] as $nextEvolution) {
            $previousEvolutionChainDB = $this->handleCurrentChain($nextEvolution, $previousChainDB, $depth);
            $this->traverseChain($nextEvolution, $rootChainJson, $previousEvolutionChainDB, $depth + 1);
        }
    }

    public function handleCurrentChain ($currentChainJson, $previousChainDB=null, $depth=0) {
        $speciesName = $currentChainJson['species']['name'];

        $evolutionChainDB = $this->createChainFromSpecies($speciesName);

        $evolutionPaths = $currentChainJson['evolution_details'];
        $this->handleEvolutionPaths($evolutionPaths, $speciesName, $evolutionChainDB);

        $evolutionChainDB->previous()->save($previousChainDB);
        $previousChainDB->next()->save($evolutionChainDB);

        return $evolutionChainDB;
    }

    public function handleEvolutionPaths ($evolutionPaths, $speciesName, $evolutionChainDB) {
        foreach ($evolutionPaths as $evolutionPath) {
            $this->handleEvolutionPath($evolutionPath, $speciesName, $evolutionChainDB);
        }
    }

    public function handleEvolutionPath ($evolutionPath, $speciesName, $evolutionChainDB) {
        // when($evolutionPath['trigger'], [$this, 'handleTrigger']);
        // Call handleXXX when value of a evolution detail item contains information
        $evolutionPathDB = EvolutionPath::create();
        foreach ($evolutionPath as $key => $value) {
            $method = 'handle'.Str::studly($key);
            if(method_exists($this, $method)) {
                when($value, [$this, $method], $evolutionPathDB, $speciesName, $evolutionChainDB);
            }
        }

        $evolutionPathDB->evolutionChain()->associate($evolutionChainDB)->save();
    }

    public function handleTrigger($triggerJson, $evolutionPathDB, $speciesName) {
        $trigger = Trigger::firstWhere('name', $triggerJson['name']);
        $evolutionPathDB->trigger()->associate($trigger)->save();
    }
}
