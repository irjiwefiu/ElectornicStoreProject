<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Category; // Import Alert model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:100',
            'description' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $filePath;
        }

        $category = Category::create($validated);

        // 🔔 Create alert
        Alert::create([
            'title' => 'New Category Added',
            'message' => "Category '{$category->name}' has been created.",
            'type' => 'success',
            'is_read' => false,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:categories,name,'.$category->id,
            'description' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $filePath = $request->file('image')->store('categories', 'public');
            $validated['image'] = $filePath;
        }

        $category->update($validated);

        // 🔔 Create alert
        Alert::create([
            'title' => 'Category Updated',
            'message' => "Category '{$category->name}' has been updated.",
            'type' => 'info',
            'is_read' => false,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Cannot delete category with existing products.');
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $categoryName = $category->name;
        $category->delete();

        // 🔔 Create alert
        Alert::create([
            'title' => 'Category Deleted',
            'message' => "Category '{$categoryName}' has been deleted.",
            'type' => 'warning',
            'is_read' => false,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
