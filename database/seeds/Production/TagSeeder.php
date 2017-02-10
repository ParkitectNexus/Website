<?php

class TagSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'type'           => 'blueprint',
                'tag'            => 'Transport',
                'slug'           => 'transport',
                'parkitect_type' => 'Transport',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Single Coaster',
                'slug'           => 'rollercoaster',
                'parkitect_type' => 'Rollercoaster',
                'primary'        => 1,
                'category'       => 'content-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Log Flume',
                'slug'           => 'log-flume',
                'parkitect_type' => 'LogFlume',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Mini Coaster',
                'slug'           => 'mini-coaster',
                'parkitect_type' => 'MiniCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Miniature Railway',
                'slug'           => 'miniature-railway',
                'parkitect_type' => 'MiniatureRailway',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Steel Coaster',
                'slug'           => 'steel-coaster',
                'parkitect_type' => 'SteelCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Suspended Coaster',
                'slug'           => 'suspended-coaster',
                'parkitect_type' => 'SuspendedCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Suspended Monorail',
                'slug'           => 'suspended-monorail',
                'parkitect_type' => 'SuspendedMonorail',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Wild Mouse',
                'slug'           => 'wild-mouse',
                'parkitect_type' => 'WildMouse',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Wing Coaster',
                'slug'           => 'wing-coaster',
                'parkitect_type' => 'WingCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Wooden Coaster',
                'slug'           => 'wooden-coaster',
                'parkitect_type' => 'WoodenCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Gentle Coaster',
                'slug'           => 'gentle-coaster',
                'parkitect_type' => 'GentleCoaster',
                'primary'        => 1,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Intense Coaster',
                'slug'           => 'intense-coaster',
                'parkitect_type' => 'IntenseCoaster',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Compact Coaster',
                'slug'           => 'compact-coaster',
                'parkitect_type' => 'CompactCoaster',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Large Coaster',
                'slug'           => 'large-coaster',
                'parkitect_type' => 'LargeCoaster',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Replica Coaster',
                'slug'           => 'replica-coaster',
                'parkitect_type' => 'ReplicaCoaster',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'park',
                'tag'            => 'Small Park',
                'slug'           => 'small-park',
                'parkitect_type' => 'SmallPark',
                'primary'        => 0,
                'category'       => 'park',
            ],
            [
                'type'           => 'park',
                'tag'            => 'Large Park',
                'slug'           => 'large-park',
                'parkitect_type' => 'LargePark',
                'primary'        => 0,
                'category'       => 'park',
            ],
            [
                'type'           => 'park',
                'tag'            => 'Scenario',
                'slug'           => 'scenario',
                'parkitect_type' => 'Scenario',
                'primary'        => 1,
                'category'       => 'scenario',
            ],
            [
                'type'           => 'park',
                'tag'            => 'Filled Park',
                'slug'           => 'filled-park',
                'parkitect_type' => 'FilledPark',
                'primary'        => 0,
                'category'       => 'park',
            ],
            [
                'type'           => 'park',
                'tag'            => 'Replica Park',
                'slug'           => 'replica-park',
                'parkitect_type' => 'ReplicaPark',
                'primary'        => 0,
                'category'       => 'park',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Water',
                'slug'           => 'water',
                'parkitect_type' => 'Water',
                'primary'        => 1,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Camera',
                'slug'           => 'camera',
                'parkitect_type' => 'Camera',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Shop',
                'slug'           => 'shop',
                'parkitect_type' => 'Shop',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Scenery',
                'slug'           => 'scenery',
                'parkitect_type' => 'Scenery',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Attraction',
                'slug'           => 'attraction',
                'parkitect_type' => 'Attraction',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Rollercoaster',
                'slug'           => 'rollercoaster',
                'parkitect_type' => 'RollercoasterMod',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Coaster Train',
                'slug'           => 'coastertrain',
                'parkitect_type' => 'CoasterTrain',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'UI',
                'slug'           => 'ui',
                'parkitect_type' => 'UI',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Cheats',
                'slug'           => 'cheats',
                'parkitect_type' => 'Cheats',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'mod',
                'tag'            => 'Gameplay',
                'slug'           => 'gameplay',
                'parkitect_type' => 'Gameplay',
                'primary'        => 0,
                'category'       => 'mod',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Modded',
                'slug'           => 'modded',
                'parkitect_type' => 'HasMods',
                'primary'        => 1,
                'category'       => 'content-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Vertical Dropcoaster',
                'slug'           => 'vertical-dropcoaster',
                'parkitect_type' => 'VerticalDropCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Alpine Coaster',
                'slug'           => 'alpine-coaster',
                'parkitect_type' => 'AlpineCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Bobsled Coaster',
                'slug'           => 'bobsled-coaster',
                'parkitect_type' => 'BobsledCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Has Scenery',
                'slug'           => 'has-scenery',
                'parkitect_type' => 'HasScenery',
                'primary'        => 1,
                'category'       => 'content-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Has Only Scenery',
                'slug'           => 'has-only-scenery',
                'parkitect_type' => 'HasOnlyScenery',
                'primary'        => 1,
                'category'       => 'content-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Has Coaster',
                'slug'           => 'has-coaster',
                'parkitect_type' => 'HasCoaster',
                'primary'        => 1,
                'category'       => 'content-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Has Flatride',
                'slug'           => 'has-flatride',
                'parkitect_type' => 'HasFlatRide',
                'primary'        => 1,
                'category'       => 'content-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Food Court',
                'slug'           => 'food-court',
                'parkitect_type' => 'FoodCourt',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Food Court',
                'slug'           => 'food-court',
                'parkitect_type' => 'FoodCourt',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Building',
                'slug'           => 'building',
                'parkitect_type' => 'Building',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Mainstreet',
                'slug'           => 'mainstreet',
                'parkitect_type' => 'Mainstreet',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Plaza',
                'slug'           => 'plaza',
                'parkitect_type' => 'Plaza',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Station',
                'slug'           => 'station',
                'parkitect_type' => 'Station',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Decoration',
                'slug'           => 'decoration',
                'parkitect_type' => 'Decoration',
                'primary'        => 0,
                'category'       => 'blueprint',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Giga Coaster',
                'slug'           => 'giga-coaster',
                'parkitect_type' => 'GigaCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Inverted Coaster',
                'slug'           => 'inverted-coaster',
                'parkitect_type' => 'InvertedCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Ghost Mansion Ride',
                'slug'           => 'ghost-mansion-ride',
                'parkitect_type' => 'GhostMansionRide',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Monorail',
                'slug'           => 'monorail',
                'parkitect_type' => 'Monorail',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Monorail',
                'slug'           => 'monorail',
                'parkitect_type' => 'Monorail',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Car Ride',
                'slug'           => 'car-ride',
                'parkitect_type' => 'CarRide',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Go-Karts',
                'slug'           => 'go-karts',
                'parkitect_type' => 'GoKarts',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Inverted Dark Ride',
                'slug'           => 'inverted-dark-ride',
                'parkitect_type' => 'InvertedDarkRide',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Mine Train Coaster',
                'slug'           => 'mine-train-coaster',
                'parkitect_type' => 'MineTrainCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Spinning Coaster',
                'slug'           => 'spinning-coaster',
                'parkitect_type' => 'SpinningCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
            [
                'type'           => 'blueprint',
                'tag'            => 'Launched Coaster',
                'slug'           => 'hydraulically-launched-coaster',
                'parkitect_type' => 'AcceleratorCoaster',
                'primary'        => 1,
                'category'       => 'coaster-types',
            ],
        ];

        foreach ($tags as $tag) {
            $existingTag = \PN\Assets\Tag::where('type', $tag['type'])->where('slug', $tag['slug'])->first();

            if($existingTag != null) {
                $existingTag->fill($tag);

                $existingTag->save();
            } else {
                factory(\PN\Assets\Tag::class)->create($tag);
            }
        }
    }
}
