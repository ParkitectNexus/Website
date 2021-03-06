<?php

class AssetStatSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assets = \PN\Assets\Asset::all();

        foreach ($assets as $asset) {
            $stats = \PN\Resources\Stats\Stat::where('type', $asset->type)->get();

            foreach ($stats as $stat) {
                \PN\Resources\Stats\ResourceStat::create([
                    'resource_id' => $asset->id,
                    'stat_id'  => $stat->id,
                    'value'    => rand(1, 1000) / 10,
                ]);
            }
        }
    }
}
