<?php

namespace App\Service;

use Ausi\SlugGenerator\SlugGenerator;

class SlugService
{
    public function slugify(string $string)
    {
        $generator = new SlugGenerator();
        return $generator->generate($string);
    }
}