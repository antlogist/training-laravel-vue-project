<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Map;
use App\Http\Resources\Map\MapIndexResource;
use App\Http\Resources\Map\MapShowResource;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Maps/Index', [
            'title' => 'Maps',
            'maps' => function() {
                return MapIndexResource::collection(
                    $maps = auth()->user()->maps()->latest()->paginate(10)
                );
            }
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Maps/Create', [
            'title' => 'Map'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'tiles' => $request->tiles,
            'user_id' => auth()->user()->id,
        ];

        Map::create($insert);

        return redirect()->route('maps');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        return Inertia::render('Maps/Show', [
            'title' => 'Map',
            'map' => new MapShowResource($map)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Map $map)
    {
        return Inertia::render('Maps/Edit', [
            'title' => 'Maps',
            'map' => new MapShowResource($map)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Map $map)
    {
        $insert = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'tiles' => $request->tiles,
        ];

        $map->where('id', $request->id)->where('user_id', auth()->user()->id)->first()->update($insert);

        return redirect()->route('maps');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Map $map)
    {
        $map->delete();
        return redirect()->back();
    }
}
