<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Http\Resources\linkResource;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\LinkCollection;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('viewAny', Link::class)) {
            return new LinkCollection(Link::paginate());
        }else{
            $links = Link::all();
            $filteredLinks = $links->filter(function ($link) {
                return Gate::allows('view', $link);
            });
            return new LinkCollection($filteredLinks);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        return new linkResource($link);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        //
    }
}
