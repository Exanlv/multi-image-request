<?php

use Exan\Mir\File;
use Exan\Mir\Mir;

require './vendor/autoload.php';

$images = $_GET['images']; // DO NOT DO THIS, this is insecure and will happily retrieve every file on your machine

$mir = new Mir();

foreach ($images as $image) {
    $mir->addImage(new File($image));
}

(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($mir->toResponse(additionalHeaders: ['Access-Control-Allow-Origin' => '*']));
