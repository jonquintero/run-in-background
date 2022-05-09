<?php

namespace App\DataTransferObjects;

class SearchData
{
    public function __construct(public readonly string $name,
        public readonly string $category, public readonly string $collection, public readonly string $find)
    {
    }
}
