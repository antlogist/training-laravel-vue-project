<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Resources\Category\CategoryIndexResource;
use App\Http\Resources\Subcategory\SubcategoryIndexResource;

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
                    $user = auth()->user()->subcategories()->latest()->paginate(10)
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

        Category::create($insert);

        return redirect()->route('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        //
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
        //
    }
}
