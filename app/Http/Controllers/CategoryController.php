<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::all();
    $title = 'Quản lí danh mục';
    $totalCategories = Category::count(); // Đếm tổng số danh mục

    return view('admin.category.index', compact('categories', 'title', 'totalCategories'));
}



    public function create()
    {
        $title = 'Thêm danh mục';
        return view('admin.category.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('categories', 'public');

        $slug = Str::slug($request->name);

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath ?? null,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Created successfully.');
    }

    public function edit($id)
    {
        $title = 'Sửa danh mục';
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category', 'title'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Category updated.');
    }


    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Category deleted.');
    }
}
