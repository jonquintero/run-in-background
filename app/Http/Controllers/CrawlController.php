<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Jobs\SearchJob;
use App\Models\Crawl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Inertia\Inertia;

class CrawlController extends Controller
{
     public function index(): \Inertia\Response
     {
         return Inertia::render('Crawl/Index', [
             'filters' => FacadeRequest::all('search', 'trashed'),
             'crawls' => Crawl::orderBy('name')
                 ->filter(FacadeRequest::only('search', 'trashed'))
                 ->paginate(10)
                 ->withQueryString()
                 ->through(fn ($crawl) => [
                     'id' => $crawl->id,
                     'name' => $crawl->name,
                     'category' => $crawl->category,
                     'collection' => $crawl->collection,
                     'find' => $crawl->find,

                 ]),
         ]);
     }

    public function create(): \Inertia\Response
    {
        return Inertia::render('Crawl/Create');
    }

    public function store(SearchRequest $request)
    {
        SearchJob::dispatch($request->search);

        return Redirect::route('crawl')->with('success', 'You search will be process in background');
    }
}
