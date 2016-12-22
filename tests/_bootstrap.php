<?php
// This is global bootstrap for autoloading
require 'bootstrap/autoload.php';
$app = require 'bootstrap/app.php';
$app->loadEnvironmentFrom('.env.testing');
$app->instance('request', new \Illuminate\Http\Request);
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();