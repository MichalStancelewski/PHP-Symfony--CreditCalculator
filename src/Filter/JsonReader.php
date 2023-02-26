<?php

namespace App\Filter;

use Symfony\Component\Finder\SplFileInfo;

class JsonReader
{

    const PATH_TO_WIBOR_JSON = __DIR__ . '/Resources/wibor.json';

    function read()
    {
        $file = new SplFileInfo(self::PATH_TO_WIBOR_JSON, '', '');
        return $jsonData = json_decode($file->getContents(), true);
    }
}