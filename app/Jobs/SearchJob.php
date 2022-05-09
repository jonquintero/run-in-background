<?php

namespace App\Jobs;

use App\Actions\UpsertSearchAction;
use App\DataTransferObjects\SearchData;
use App\Models\Crawl;
use App\Services\ConsumeExternalServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SearchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ConsumeExternalServices, UpsertSearchAction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public readonly string $request)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

          $this->getEachItune();
          $this->getEachTvShow();
          $this->formatResponseSearchPeople();

    }

    private function upsert($request, $search)
    {
        $data = new SearchData(...$request);
        return $this->execute($search, $data);
    }

    /**
     * @return void
     */
    public function getEachItune(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->makeRequest()[$i]->collect('results')->each(function ($item, $key) {
                $dataStore = [
                    'name' => $item['artistName'],
                    'category' => $item['kind'],
                    'collection' => $item['trackName'],
                    'find' => 'https://www.apple.com/v/itunes/home/k/images/overview/itunes_logo__dwjkvx332d0m_large.png'
                ];

                $this->upsert($dataStore, new Crawl());
            });
        }
    }

    public function getEachTvShow(): void
    {
        $this->makeRequest()[3]->collect('*.show')->each(function ($item, $key) {
            $dataStore = [
                'name' => $item['name'],
                'category' => 'tv-show',
                'collection' => $item['name'],
                'find' => 'https://www.showtv.com.tr/assets/v2/images/desktop/logo/showtv.svg'
            ];

            $this->upsert($dataStore, new Crawl());
        });
    }

    public function formatResponseSearchPeople(): void
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $doc->loadXML($this->makeRequest()[4]);
        $XMLresults = $doc->getElementsByTagName("Name");

        if (count($XMLresults) > 0) {
            for ($i = 0; $i < count($XMLresults); $i++) {
                $dataStore = [
                    'name' => $XMLresults->item($i)->nodeValue,
                    'category' => 'people',
                    'collection' => $XMLresults->item($i)->nodeValue,
                    'find' => 'https://thumbs.dreamstime.com/z/elemento-del-dise%C3%B1o-de-pin-location-people-icon-logo-97028649.jpg'
                ];

                $this->upsert($dataStore, new Crawl());

            }
        }
    }
}

