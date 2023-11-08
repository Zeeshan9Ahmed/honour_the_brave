<?php

namespace App\Http\Controllers\Business;

use App\Events\CreateProductEvent;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('category_type', 'normal')->get();
        // return  Product::with('image')->find(1);
        return view('web.business.products.index', compact('categories'));
    }

    public function addProduct()
    {
        $categories = Category::where('category_type', 'normal')->get(['id', 'image', 'category_name']);
        // return $categories;
        return view('web.business.products.add_product', compact('categories'));
    }

    public function saveProduct(Request $request)
    {
        // dd($request->all());

        $product = Product::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'product_image' => '',
            'title' => $request->title,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'detail' => $request->detail,
        ]);
        foreach ($request->file('files') ?? [] as $image) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploadedimages'), $imageName);
            $image_url = 'uploadedimages/' . $imageName;

            $data = new Image([
                'image_url' => $image_url,
            ]);
            $product->images()->save($data);
        }

        $category = Category::find(auth()->user()->category_id);
         //Send Notification Of New Product
         $type = $category->category_name=="Resturants"?"resturant":(strtolower($category->category_name));
         $message = "A New $type product has been added.";
        event(new CreateProductEvent($message));
       
        
        return response()->json([
            'status' => 1,
            'redirect_url' => url('business/dashboard'),
            'message' => 'Profile Updated',
        ]);
    }

    public function editProduct(Request $request) {
        $product = Product::with('image')->find($request->product_id);
        $product->category_id = $request->category_id;
        $product->title = $request->title;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->detail = $request->detail;
        $product->save();
        $images_data = [];
        foreach ($request->file('files') ?? [] as $image) {
            $uuid = Str::uuid();
            $imageName = $uuid . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploadedimages'), $imageName);
            $image_url = 'uploadedimages/' . $imageName;
            $data = new Image([
                'image_url' => $image_url,
            ]);
            $image = $product->images()->save($data);
            $images_data[] = ['id' => $image->id, 'image_url' => $image->image_url]; 
        }

        return response()->json([
            'status' => 1,
            'data' => $images_data,
            'product' => $product,
            'message' => 'Product Updated',
        ]);

        return $request->all();
    }

    public function categoryProducts(Request $request)
    {
        $products = Product::with('image')->where(['category_id' => $request->category_id, 'user_id' => auth()->id()])->get();
        return response()->json([
            'status' => 1,
            'data' => $products,
            'message' => 'Category Products',
        ]);
    }

    public function getProduct (Request $request) {
        $product = Product::with('images')->where('id', $request->product_id)->first();
        return response()->json([
            'status' => 1,
            'data' => $product,
            'message' => 'Single Product',
        ]);
    }

    public function deleteProductImage (Request $request ) {
        $image = Image::find($request->image_id);
        removeFile($image->image_url);
        $image->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Image Removed',
        ]);
    }

    public function deleteProduct (Request $request) {
        $product = Product::find($request->product_id);

        foreach ($product->images()->get() as $key => $image) {
            removeFile($image->image_url);
            $image->delete();
        }
        $product->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Product Removed',
        ]);
    }
    
}
