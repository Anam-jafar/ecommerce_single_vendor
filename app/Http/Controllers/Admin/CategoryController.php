<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Sub_Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::where('deleted', '!=', 1)->latest()->get();
        return view('category.allCategories', compact('categories')); 
    }

    public function addCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'category_name' => 'required|string|max:191|unique:categories',
            ]);

            $category = new Category();
            $category->category_name = $validatedData['category_name'];
            $category->slug = strtolower(str_replace(" ","-", $validatedData['category_name']));
            $category->status = $request->status;


            if($category->save()){
                return redirect()->route('allCategories')->with('success', 'Category added successfully.');
            }
            
        } else {
            return view('category.addCategory');
        }
    }

    public function editCategory(Request $request, $id = null)
    {
        $category = Category::findOrFail($id);

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'category_name' => 'required|string|max:191|unique:categories,category_name,' . $category->id,
            ]);

            $category->category_name = $validatedData['category_name'];
            $category->slug = strtolower(str_replace(" ","-", $validatedData['category_name']));
            $category->status = $request->status;


            if($category->save()){
                return redirect()->route('allCategories')->with('success', 'Category updated successfully.');
            }
            
        } else {
            return view('category.editCategory', compact('category'));
        }
    }

    public function deleteCategory($id = null){
        $category = Category::findOrFail($id);
        $category->deleted = 1;

        if($category->save()){
            return redirect()->route('allCategories')->with('error', 'Category deleted successfully.');
        }

    }

    public function getSubcategories(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $subcategories = Sub_Category::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }
}
