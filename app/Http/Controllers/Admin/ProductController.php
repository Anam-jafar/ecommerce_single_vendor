<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sub_Category;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index(){
        $products = Product::where('deleted', '!=', 1)->latest()->get();
        return view('product.allProducts', compact('products')); 
    }

    public function addProduct(Request $request){
        $categories = Category::where('deleted', '!=', 1)->latest()->get();
        $subcategories = Sub_Category::where('deleted', '!=', 1)->latest()->get();

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:191',
                'description' => 'required|string',
                'price' => 'required|numeric|min:1',
                'quantity' => 'required|numeric|min:1',
                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'

            ]);
            $product = new Product();
            $product->product_name = $validatedData['product_name'];
            $product->description = $validatedData['description'];
            $product->price = $validatedData['price'];
            $product->quantity = $validatedData['quantity'];
            $product->product_category_id = $request->product_category_id ;
            $product->product_sub_category_id = $request->product_sub_category_id ;
            $product->slug = strtolower(str_replace(" ","-", $validatedData['product_name']));
            $product->status = $request->status ;
            $product->product_category_name =  Category::where('id', $request->product_category_id)->value('category_name');
            $product->product_sub_category_name = Sub_Category::findOrFail($request->product_sub_category_id)->sub_category_name;
            

            $image = $request->file('product_image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $image_name);
            $image_url = 'uploads/'.$image_name;
            $product->product_image = $image_url;
            if($product->save()){
                Category::where('id', $request->product_category_id)->increment('product_count', 1);
                Sub_Category::where('id', $request->product_sub_category_id)->increment('product_count', 1);
                return redirect()->route('allProducts')->with('success', 'Product added successfully.');                
            }

        } else {
            return view('product.addProduct', compact(['categories', 'subcategories']));
        }
        
    }

    public function editProduct(Request $request, $id = null){
        $product = Product::findOrFail($id);
        $categories = Category::where('deleted', '!=', 1)->latest()->get();
        $subcategories = Sub_Category::where('deleted', '!=', 1)->latest()->get();

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'product_name' => 'string|max:191',
                'description' => 'string',
                'price' => 'numeric|min:1',
                'quantity' => 'numeric|min:1',
                'product_image' => 'image|mimes:jpeg,png,jpg,gif,svg'

            ]);
            $product->product_name = $validatedData['product_name'];
            $product->description = $validatedData['description'];
            $product->price = $validatedData['price'];
            $product->quantity = $validatedData['quantity'];
            $product->slug = strtolower(str_replace(" ","-", $validatedData['product_name']));
            $product->status = $request->status ;

            if($product->product_category_id != $request->product_category_id){
                Category::where('id', $product->product_category_id)->decrement('product_count',1);
                $product->product_category_id = $request->product_category_id;
                Category::where('id', $request->product_category_id)->increment('product_count',1);
                $product->product_category_name = Category::where('id', $request->product_category_id)->value('category_name');
            }
            if($product->product_sub_category_id != $request->product_sub_category_id){
                Sub_Category::where('id', $product->product_sub_category_id)->decrement('product_count',1);
                $product->product_sub_category_id = $request->product_sub_category_id;
                Sub_Category::where('id', $request->product_sub_category_id)->increment('product_count',1);
                $product->product_sub_category_name = Category::where('id', $request->product_sub_category_id)->value('sub_category_name');
            }
            

            if(isset($request->product_image)){
                $image = $request->file('product_image');
                $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $image_name);
                $image_url = 'uploads/'.$image_name;
                $product->product_image = $image_url;
            }
            if($product->save()){
                return redirect()->route('allProducts')->with('success', 'Product updates successfully.');                
            }

        } else {
            return view('product.editProduct', compact(['categories', 'subcategories', 'product']));
        }
        
    }

    public function deleteProduct($id = null){
        $product = Product::findOrFail($id);
        $product->deleted = 1;
        if($product->save()){
            Sub_Category::where('id', $product->product_sub_category_id)->decrement('product_count',1);
            Category::where('id', $product->product_category_id)->decrement('product_count',1);
            return redirect()->route('allProducts')->with('error', 'Product deleted successfully.');
        }

    }


}
