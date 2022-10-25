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

            // 4. Fetch all the data for a specific pokedexes
            $chainJson = fetchJson($chainUrl);

            // 5. traverse chain
            $this->traverseChain($chainJson['chain']);

        });
    }

    public function traverseChain($currentChainJson, $previousChainDB=null) {
        $nextEvolutions = $currentChainJson['evolves_to'];
        $previousEvolutionChainDB = $this->handleCurrentChain($currentChainJson, $previousChainDB);

        foreach ($nextEvolutions as $nextEvolution) {
            $this->traverseChain($nextEvolution, $previousEvolutionChainDB);
        }
    }

    public function handleCurrentChain ($currentChainJson, $previousChainDB=null) {
        $speciesName = $currentChainJson['species']['name'];
        $speciesDB = Species::firstWhere('name', $speciesName);

        $evolutionChain = $speciesDB->evolutionChain()->firstOrCreate();

        $evolutionPaths = $currentChainJson['evolution_details'];
        $this->handleEvolutionPaths($evolutionPaths);

        if (isset($previousChainDB)) {
            $evolutionChain->evolveTo()->save($previousChainDB);
            $previousChainDB->evolveFrom()->save($evolutionChain);

        }
        return $evolutionChain;
    }

    public function handleEvolutionPaths ($evolutionPaths) {
        foreach ($evolutionPaths as $evolutionPath) {
            $this->handleEvolutionPath($evolutionPath);
        }
    }

    public function handleEvolutionPath ($evolutionPath) {
        // when($evolutionPath['trigger'], [$this, 'handleTrigger']);
        // Call handleXXX when value of a evolution detail item contains information
        $evolutionPathDB = EvolutionPath::create();
        foreach ($evolutionPath as $key => $value) {
            $method = 'handle'.Str::studly($key);
            if(method_exists($this, $method)) {
                when($value, [$this, $method], $evolutionPathDB);
            }
        }

    }

    public function handleTrigger($triggerJson, $evolutionPathDB) {
        $trigger = Trigger::firstWhere('name', $triggerJson['name']);
        $evolutionPathDB->trigger()->associate($trigger)->save();
    }

}
