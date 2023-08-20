<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'All Categories';
        $search = $request->search;
        $categories = Category::query();

        if ($search) {
            $pageTitle = "Category Search - $search";
            $categories = $categories->where('name', 'like',"%$search%");
        }

        $categories = $categories->latest()->paginate(getPaginate());
        $emptyMessage = 'No category found';

        return view('admin.category.index', compact('pageTitle', 'categories', 'emptyMessage'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        if ($id) {
            $category = Category::findOrFail($id);
            $message = 'Category updated successfully';
            $category->status = $request->status ? 1 : 0;

        }else {
            $category = new Category();
            $message = 'Category added successfully';
        }

        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

}
