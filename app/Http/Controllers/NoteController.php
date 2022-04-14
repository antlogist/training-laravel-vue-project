<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\Note\NoteIndexResource;
use App\Http\Resources\Note\NoteShowResource;
use App\Http\Resources\Category\CategoryShowResource;
use App\Http\Resources\Category\CategoryIndexResource;
use App\Http\Resources\Subcategory\SubcategoryShowResource;
use App\Http\Resources\Subcategory\SubcategoryIndexResource;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Notes/Index', [
            'title' => 'Notes',
            'notes' => function() {
                return NoteIndexResource::collection(
                    $notes = auth()->user()->notes()->latest()->paginate(10)
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
        $categories = auth()->user()->categories()->latest()->get();
        $subcategories = auth()->user()->subcategories()->latest()->get();

        return Inertia::render('Notes/Create', [
            'title' => 'Note Creation',
            'categories' => CategoryIndexResource::collection($categories),
            'subcategories' => SubcategoryIndexResource::collection($subcategories)
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
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id
        ];

        Note::create($insert);

        return redirect()->route('notes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */

    public function show(Note $note)
    {
        $category = $note->category;
        $subcategory = $note->subcategory;

        return Inertia::render('Notes/Show', [
            'title' => $note->title,
            'note' => new NoteShowResource($note),

            'category' => $category ? new CategoryShowResource( $category ) : null,
            'subcategory' => $subcategory ? new SubcategoryShowResource( $subcategory ) : null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        $categories = auth()->user()->categories()->latest()->get();
        $subcategories = auth()->user()->subcategories()->latest()->get();

        $category = $note->category;
        $subcategory = $note->subcategory;

        return Inertia::render('Notes/Edit', [
            'title' => 'Edit Note: ' . $note->title,
            'note' => new NoteShowResource(
                $note
            ),

            'category' => $category ? new CategoryShowResource( $category ) : null,
            'subcategory' => $subcategory ? new SubcategoryShowResource( $subcategory ) : null,

            'categories' => CategoryIndexResource::collection($categories),
            'subcategories' => SubcategoryIndexResource::collection($subcategories)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $insert = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ];

        $note->where('id', $request->id)->where('user_id', auth()->user()->id)->first()->update($insert);

        return redirect()->route('notes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->back();
    }
}
