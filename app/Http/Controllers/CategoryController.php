<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('category')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $editCategory = Category::findOrFail($id);
        $categories = Category::all();
        return view('admin.category', compact('categories', 'editCategory'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id,
        ]);

        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('category')->with('success', 'Category updated successfully.');
    }

    public function delete($id)
    {
        $deleteCategory = Category::findOrFail($id);
        $categories = Category::all();
        return view('admin.category', compact('categories', 'deleteCategory'));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category')->with('success', 'Category deleted successfully.');
    }
}
