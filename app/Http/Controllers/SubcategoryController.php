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

    public function show(Category $category, Subcategory $subcategory)
    {
        return Inertia::render('Subcategories/Show', [
            'title' => $subcategory->title,
            'category' => new CategoryShowResource($category),
            'subcategory' =>  new SubcategoryShowResource(
                $subcategory
            )
        ]);
    }

    public function showWithoutCategory(Subcategory $subcategory)
    {
        return Inertia::render('Subcategories/Show', [
            'title' => $subcategory->title,
            'category' => null,
            'subcategory' =>  new SubcategoryShowResource(
                $subcategory
            )
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Subcategory $subcategory)
    {
        $categories = auth()->user()->categories()->latest()->get();

        return Inertia::render('Subcategories/Edit', [
            'title' => 'Edit Subcategory: ' . $subcategory->title,
            'subcategory' => new SubcategoryShowResource($subcategory),
            'category' => new CategoryShowResource($category),
            'categories' => CategoryIndexResource::collection($categories)
        ]);
    }

    public function editWithoutCategory(Subcategory $subcategory)
    {
        $categories = auth()->user()->categories()->latest()->get();

        return Inertia::render('Subcategories/Edit', [
            'title' => 'Edit Subcategory: ' . $subcategory->title,
            'subcategory' => new SubcategoryShowResource($subcategory),
            'category' => null,
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
    public function update(StoreSubcategoryRequest $request, Subcategory $subcategory)
    {
        $request->validated();

        $insert = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id
        ];

        $subcategory->where('id', $request->id)->where('user_id', auth()->user()->id)->first()->update($insert);

        return redirect()->route('subcategories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Subcategory::where('id', $id)->where('user_id', auth()->user()->id)->first()->delete();

        return redirect()->back();
    }
}
