<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\Category\CategoryIndexResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'title' => 'Category',
            'categories' => function() {
                return CategoryIndexResource::collection(
                    $user = auth()->user()->categories()->latest()->paginate(10)
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
        return Inertia::render('Categories/Create', [
            'title' => 'Category',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $insert = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'user_id' => auth()->user()->id
        ];

        Category::create($insert);

        return redirect()->route('categories');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function show($slug) {
        // dd($slug);
        return Inertia::render('Categories/Show', [
            'title' => 'Category',
            'category' => Category::where('slug', $slug)->where('user_id', auth()->user()->id)->first()->showResource()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return Inertia::render('Categories/Edit', [
            'title' => 'Category',
            'category' => Category::where('slug', $slug)->where('user_id', auth()->user()->id)->first()->showResource()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $insert = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
        ];

        $category->where('id', $request->id)->where('user_id', auth()->user()->id)->first()->update($insert);

        return redirect()->route('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        Category::where('slug', $slug)->where('user_id', auth()->user()->id)->first()->delete();

        return redirect()->back();
    }
}
