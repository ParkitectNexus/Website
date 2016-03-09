<?php

namespace PN\Resources\Extractors;


use PN\Resources\Exceptions\NotAValidBlueprint;

class BlueprintExtractor implements ExtractorInterface
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getData()
    {
        return \Cache::remember('resource.extract.blueprint.' . $this->path, 10, function () {
            $arguments = escapeshellarg(app_path('../bin/ParkitectNexus.AssetTools.exe')) . " blueprint " .
                "--input " . \ResourceUtil::escapeArgument($this->path);

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $result = exec("$arguments", $lines, $errorCode);
            } else {
                $result = exec("PATH=\$PATH:/usr/local/bin; mono $arguments 2>&1", $lines, $errorCode);
            }

            if ($result == null || $errorCode != 0) {
                throw new NotAValidBlueprint($this->path);
            }

            $json = json_decode($result, true);

            if ($json == null) {
                throw new NotAValidBlueprint($this->path);
            }

            return $json;
        });
    }
}