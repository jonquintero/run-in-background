<?php

namespace App\Actions;


use App\DataTransferObjects\SearchData;
use App\Models\Crawl;

trait UpsertSearchAction
{
    public function execute(Crawl $crawl, SearchData $searchData): Crawl
    {
        $crawl->name = $searchData->name;
        $crawl->category = $searchData->category;
        $crawl->collection = $searchData->collection;
        $crawl->find = $searchData->find;
        $crawl->save();

        return $crawl;
    }
}
