<?php

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use PN\Assets\Asset;
use PN\BuildOffs\BuildOff;
use PN\BuildOffs\Jobs\RankBuildOff;

class RankBuildOffTest extends \Codeception\Test\Unit
{
    use DispatchesJobs;
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testRankBuildoff()
    {
        //arrange
        $buildOff = \Mockery::mock(BuildOff::class)->makePartial();
        $buildOff->shouldReceive("wasPreviouslyRanked")->andReturn(false);
        $buildOff->id = 201;

        $asset1 = \Mockery::mock(Asset::class)->makePartial();
        $asset1->like_count = 10;
        $asset1->download_count = 400;
        $asset1->id = 99;

        $asset2 = \Mockery::mock(Asset::class)->makePartial();
        $asset2->like_count = 20;
        $asset2->download_count = 500;
        $asset2->id = 23;

        $asset3 = \Mockery::mock(Asset::class)->makePartial();
        $asset3->like_count = 10;
        $asset3->download_count = 100;
        $asset3->id = 153;

        $asset4 = \Mockery::mock(Asset::class)->makePartial();
        $asset4->like_count = 15;
        $asset4->download_count = 9000;
        $asset4->id = 1123;

        \AssetRepo::shouldReceive("forBuildOff")
            ->with($buildOff)
            ->once()
            ->andReturn(new Collection([
                $asset1,
                $asset2,
                $asset3,
                $asset4
            ]));


        $this->ranks = [];
        \RankRepo::shouldReceive("add")->with(\Mockery::on(function ($args) {
            array_push($this->ranks, [
                "buildoff_id" => $args->buildoff_id,
                "asset_id" => $args->asset_id,
                "score" => $args->score,
                "rank" => $args->rank,
            ]);
            return true;
        }));


        $data = [
            "buildOff" => $buildOff
        ];

        //act
        $this->dispatch(app(RankBuildOff::class, $data));

        //assert
        $this->assertContains([
            "buildoff_id" => 201,
            "asset_id" => 23,
            "score" => 20,
            "rank" => 1,

        ], $this->ranks);

        $this->assertContains([
            "buildoff_id" => 201,
            "asset_id" => 1123,
            "score" => 15,
            "rank" => 2,
        ], $this->ranks);

        $this->assertContains([
            "buildoff_id" => 201,
            "asset_id" => 99,
            "score" => 10,
            "rank" => 3,
        ], $this->ranks);

        $this->assertContains([
            "buildoff_id" => 201,
            "asset_id" => 153,
            "score" => 10,
            "rank" => 4,
        ], $this->ranks);

    }
}
