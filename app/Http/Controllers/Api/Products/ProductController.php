<?php

namespace App\Http\Controllers\Api\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FavouriteUnFavouriteProductRequest;
use App\Http\Requests\Api\GetBusinessProductRequest;
use App\Models\Favourite;
use App\Models\Product;

class ProductController extends Controller
{
    public function getBusinessProducts(GetBusinessProductRequest $request)
    {

        $products = Product::with('images')->select('*')
            ->selectRaw('(select category_name from categories where id = category_id LIMIT 1 ) as category_name')
            ->selectRaw('(select count(id) from favourites where product_id = products.id AND user_id = '.auth()->id().' ) as is_favourite')
            ->where('user_id', $request->business_id)
            ->get()
            ->filter(function ($value) {
                return $value->category_name != null;
            })
            ->groupBy('category_name');

        $products = $products->values()->map(function ($products) {
            return [
                'category_name' => $products->first()->category_name,
                'products' => $products
                    ->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'title' => $product->title,
                            'quantity' => $product->quantity,
                            'price' => $product->price,
                            'detail' => $product->detail,
                            'is_favourite' => $product->is_favourite,
                            'images' => $product->images,
                        ];
                    }),
            ];
        });

        return apiSuccessMessage('Products', $products);
    }

    public function favouriteUnfavouriteProduct(FavouriteUnFavouriteProductRequest $request)
    {
        $data = [
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ];

        $favourite = Favourite::where($data)->first();
        $message = '';
        if (! $favourite) {
            Favourite::create($data);
            $message = 'Added to Favourite';
        } else {
            $favourite->delete();
            $message = 'Removed From Favourite';
        }

        return commonSuccessMessage($message);

    }

    public function favouriteProducts()
    {
        $prd_ids = Favourite::where('user_id', auth()->id())->pluck('product_id');
        $products = Product::with('images')->whereIn('id', $prd_ids)->get(['id', 'title', 'price', 'quantity', 'detail']);

        return apiSuccessMessage('Success', $products);

    }
}
