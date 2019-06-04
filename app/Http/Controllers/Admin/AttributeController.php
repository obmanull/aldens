<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Attribute;
use App\Entities\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $typesList = Attribute::typesList();
        return view('admin.categories.attributes.create', compact('category', 'typesList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'type' => ['required', 'string', 'max:255', Rule::in(array_keys(Attribute::typesList()))],
            'required' => 'nullable|string',
            'variants' => 'nullable|string',
            'sort' => 'required|integer',
        ]);

        $category->attributes()->create([
            'name' => $request['name'],
            'type' => $request['type'],
            'required' => (bool)$request['required'],
            'variants' => array_map('trim', preg_split('#[\r\n]+#', $request['variants'])),
            'sort' => $request['sort'],
        ]);

        return redirect()->route('admin.categories.show', [$category]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Attribute $attribute)
    {
        return view('admin.categories.attributes.show', compact('category', 'attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Attribute $attribute)
    {
        $typesList = Attribute::typesList();
        return view('admin.categories.attributes.edit', compact('category', 'attribute', 'typesList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, Attribute $attribute)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'type' => ['required', 'string', 'max:255', Rule::in(array_keys(Attribute::typesList()))],
            'required' => 'nullable|string',
            'variants' => 'nullable|string',
            'sort' => 'required|integer',
        ]);


        Attribute::findOrFail($attribute->id)->update([
            'name' => $request['name'],
            'type' => $request['type'],
            'required' => (bool)$request['required'],
            'variants' => array_map('trim', preg_split('#[\r\n]+#', $request['variants'])),
            'sort' => $request['sort'],
        ]);

        return redirect()->route('admin.categories.show', [$category]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
