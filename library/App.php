<?php

namespace Municipio;

class App
{
    public function __construct()
    {
        new \Municipio\Theme\Enqueue();
        new \Municipio\Theme\Support();
    }
}
