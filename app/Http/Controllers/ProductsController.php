<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;
class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::with('category')->get(); // Get all products with their category
        $categories = Category::all(); // Get all categories
        return view('admin.products', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255|unique:products,product_name',
            'description' => 'required|string',
            'price' => 'required|integer',
            'stock_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Products::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        // Retrieve the product by ID, or fail if not found
        $product = Products::findOrFail($id);
    
        // Get all categories for the dropdown or selection
        $categories = Category::all();
        $products = Products::with('category')->get();
        // Return the view with the product and categories
        return view('admin.products', compact('products', 'categories','product'));
    }
    

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        
        // Validate input
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255|unique:products,product_name,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|integer',
            'stock_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePath = $product->image; // Default to existing image
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $deleteProduct = Products::findOrFail($id);
    
        $categories = Category::all();
        $products = Products::with('category')->get();
    
        // Return the view with the product details for deletion
        return view('admin.products', compact('deleteProduct', 'categories', 'products'));
    }
    

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        // Delete the image from storage if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }
}
