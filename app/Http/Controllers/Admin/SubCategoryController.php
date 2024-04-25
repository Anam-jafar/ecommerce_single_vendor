<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sub_Category;

class SubCategoryController extends Controller
{
    public function index(){
        $subcategories = Sub_Category::where('deleted', '!=', 1)->latest()->get(); 
        return view('subcategory.allSubCategories', compact('subcategories')); 
    }

    public function addSubCategory(Request $request)
    {

        $categories = Category::where('deleted', '!=', 1)->latest()->get();
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'sub_category_name' => 'required|string|max:191|unique:sub__categories',
            ]);

            $sub_category = new Sub_Category();
            $sub_category->sub_category_name = $validatedData['sub_category_name'];
            $sub_category->slug = strtolower(str_replace(" ","-", $validatedData['sub_category_name']));
            $sub_category->status = $request->status;
            $sub_category->category_id = $request->category_id;
            $sub_category->category_name = Category::findOrFail($request->category_id)->category_name;


            if($sub_category->save()){
                Category::where('id', $request->category_id)->increment('sub_category_count',1);
                return redirect()->route('allSubCategories')->with('success', 'Sub-Category added successfully.');
            }
            
        } else {
            return view('subcategory.addSubCategory', compact('categories'));
        }
    }

    public function editSubCategory(Request $request, $id = null)
    {
        $sub_category = Sub_Category::findOrFail($id);
        $categories = Category::where('deleted', '!=', 1)->latest()->get();

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'sub_category_name' => 'required|string|max:191|unique:sub__categories,sub_category_name,' . $sub_category->id,
            ]);

            $sub_category->sub_category_name = $validatedData['sub_category_name'];
            $sub_category->slug = strtolower(str_replace(" ","-", $validatedData['sub_category_name']));
            $sub_category->status = $request->status;
            if($sub_category->category_id != $request->category_id){
                Category::where('id', $sub_category->category_id)->decrement('sub_category_count',1);
                $sub_category->category_id = $request->category_id;
                Category::where('id', $request->category_id)->increment('sub_category_count',1);
                $sub_category->category_name = Category::findOrFail($request->category_id)->category_name;
            }
            


            if($sub_category->save()){
                return redirect()->route('allSubCategories')->with('success', 'Sub-Category updated successfully.');
            }
            
        } else {
            return view('subcategory.editSubCategory', compact(['sub_category', 'categories']));
        }
    }

    public function deleteSubCategory($id = null){
        $subcategory = Sub_Category::findOrFail($id);
        $subcategory->deleted = 1;
        Category::where('id', $subcategory->category_id)->decrement('sub_category_count',1);

        if($subcategory->save()){
            return redirect()->route('allSubCategories')->with('error', 'Sub-Category deleted successfully.');
        }

    }
}
