<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Category;
use App\Http\Requests\Admin\Category\CreateRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::defaultOrder()->withDepth()->get();
        return view('admin.categories.show', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::defaultOrder()->withDepth()->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function up(Category $category)
    {
        $category->up();
        return redirect()->back();
    }

    public function down(Category $category)
    {
        $category->down();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        Category::create($request->all());
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display display children categories.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $categories = Category::defaultOrder()->withDepth()->get();
        return view('admin.categories.show', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        /**
         * Select all categories without current category and own children.
         */
        $categories = Category::where('_lft', '<', $category->_lft)->orWhere('_rgt', '>', $category->_rgt)
            ->defaultOrder()
            ->withDepth()
            ->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Category $category
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->all());
        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}
