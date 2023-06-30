<?php

namespace App\Classes\Convertors;

interface StorageFileInterface
{
    public function storage($path, $options = 'public');
}