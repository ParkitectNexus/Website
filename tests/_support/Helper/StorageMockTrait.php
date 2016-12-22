<?php

namespace Helper;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

trait StorageMockTrait
{
    protected function mockStorage()
    {
        Storage::extend('mock', function () {
            return \Mockery::mock(Filesystem::class);
        });

        \Config::set('filesystems.disks.mock', ['driver' => 'mock']);
        \Config::set('filesystems.default', 'mock');

        return \Storage::disk();
    }
}