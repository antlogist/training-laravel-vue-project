<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Resources\Category\CategoryIndexResource;
use App\Http\Resources\Category\CategoryShowResource;
use App\Http\Resources\Subcategory\SubcategoryIndexResource;
use App\Http\Resources\Subcategory\SubcategoryShowResource;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Subcategories/Index', [
            'title' => 'Subcategory',
            'subcategories' => function() {
                return SubcategoryIndexResource::collection(
                    $subcategory = auth()->user()->subcategories()->latest()->paginate(10)
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
        return Inertia::render('Subcategories/Create', [
            'title' => 'Subcategory',
            'categories' => function() {
                return CategoryIndexResource::collection(
                    $categories = auth()->user()->categories()->get()->sortBy('title')
                );
            }
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubcategoryRequest $request)
    {
        $validated = $request->validated();

        $insert = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id
        ];

        Subcategory::create($insert);

        return redirect()->route('subcategories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        $slug = $subcategory->slug;

        $category = Subcategory::findOrFail($subcategory->id)->category()->get()->first();

        if($category) {
            $category = new CategoryShowResource(
                $category
            );
        } else {
            $category = null;
        };

        return Inertia::render('Subcategories/Show', [
            'title' => $subcategory->title,
            'category' => $category,
            'subcategory' =>  new SubcategoryShowResource(
                Subcategory::where('slug', $slug)->
                where('user_id', auth()->user()->id)->
                firstOrFail()
            )
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = auth()->user()->categories()->latest()->get();

        return Inertia::render('Subcategories/Edit', [
            'title' => 'Subcategory',
            'subcategory' => new SubcategoryShowResource($subcategory),
            'categories' => CategoryIndexResource::collection($categories)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {

        $slug = $subcategory->slug;

        Subcategory::where('slug', $slug)->where('user_id', auth()->user()->id)->first()->delete();

        return redirect()->back();
    }
}
