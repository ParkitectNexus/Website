<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;
use Codeception\TestCase;
use Illuminate\Support\Facades\Hash;
use PN\Assets\Asset;
use PN\Media\Image;
use PN\Resources\Facades\ResourceUtil;
use PN\Resources\Resource;
use League\FactoryMuffin\Faker\Facade as Faker;

use League\FactoryMuffin\FactoryMuffin;
use PN\Users\User;

class FactoryHelper extends Module
{

    /**
     * @var \League\FactoryMuffin\Factory
     */
    protected $factory;

    public function _initialize()
    {

        $this->factory = new FactoryMuffin();

        $this->factory->define(Image::class)->setDefinitions([
            'source' => 'imageUrl|100;100'
        ]);
        $this->factory->define('large:'. Image::class)->setDefinitions([
            'source' => 'imageUrl|1280;720'
        ]);

        $this->factory->define(User::class)->setDefinitions([
            'identifier'     => str_random(10),
            'username'       => Faker::firstNameMale(),
            'name'           => Faker::name(),
            'email'          => Faker::email(),
            'password'       => \Hash::make('password'),
            'remember_token' => str_random(10),
            'social'         => 0,
        ]);

        $this->factory->define(Resource::class )->setDefinitions([
            'identifier' => str_random(10),
            'name'       => Faker::name(),
            'description' => Faker::text(),

        ]);

        $this->factory->define(Asset::class )->setDefinitions([
            'identifier' => str_random(10),
            'name'       => Faker::name(),
            'description' => Faker::text(),
            'user_id' => function(){

                return User::inRandomOrder()->first()->id;
            },
            'image_id' => function($ob,$saved)  {
                return Image::inRandomOrder()->first()->id;
            }
        ]);
        $this->factory->define('park:'. Asset::class )->setDefinitions([
            'resource_id' => function($ob,$saved){
                $resource = ResourceUtil::make(base_path('test/files/parks.txt'));
                $resource->save();
                return $resource->id;
            }
        ]);
        $this->factory->define('blueprint:'. Asset::class)->setDefinitions([
            'resource_id' => function(){
                $resource = ResourceUtil::make(base_path('test/files/blueprints/new_style.png'));
                $resource->save();
                return $resource->id;
            }
        ]);

        $this->factory->define('mod:'. Asset::class )->setDefinitions([
            'resource_id' => function(){
                $resource = ResourceUtil::make("https://github.com/ParkitectNexus/CoasterCam");
                $resource->save();
                return $resource->id;
            }
        ]);



    }

    /**
     * @return \League\FactoryMuffin\Factory
     */
    public  function factory(){
        return $this->factory;
    }

    public function _after(TestCase $test)
    {
        // actually this is not needed
        // if you use cleanup: true option
        // in Laravel4 module
        $this->factory->deleteSaved();
    }
}
