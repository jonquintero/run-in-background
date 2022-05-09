<?php


namespace App\Services;


use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait ConsumeExternalServices
{

    /**
     * METODO QUE PERMITE LA CONEXION A LOS DIFERENTES SERVICIOS

     * @return array
     */
    public function makeRequest(): array
    {
        //return Http::get($baseUri, $queryParams);
        return  Http::pool(fn (Pool $pool) => [
            $pool->get(config('services.itunes.base_uri'), $this->bodyItunes(config('services.itunes.music'))),
            $pool->get(config('services.itunes.base_uri'), $this->bodyItunes(config('services.itunes.movies'))),
            $pool->get(config('services.itunes.base_uri'), $this->bodyItunes(config('services.itunes.ebook'))),
            $pool->get( config('services.tvmaze.base_uri'), $this->bodyTvShow()),
            $pool->get( config('services.searchpeople.base_uri'), $this->bodySearchPeople()),
        ]);


    }

    public function bodyItunes($mediaSearch): array
    {
        return [
                'term' => $this->request,
                'media' => $mediaSearch,
        ];

    }

    public function bodyTvShow(): array
    {
        return [
            'q' => $this->request,
        ];
    }

    public function bodySearchPeople(): array
    {
        return  [
            'soap_method' => config('services.searchpeople.soap_method'),
            'name' => $this->request,
        ];
    }
}
