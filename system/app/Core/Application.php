<?php

namespace App\Core;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public function publicPath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . '..';
    }
}