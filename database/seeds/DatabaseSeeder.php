<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AssetSeeder::class);
        $this->call(AssetDependenciesSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(DownloadSeeder::class);
        $this->call(ViewSeeder::class);
    }
}
