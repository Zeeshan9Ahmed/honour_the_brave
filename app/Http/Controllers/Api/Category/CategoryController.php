<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessCategoriesResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getBusinessCategories()
    {
        $categories = Category::with('business:id,business_name,avatar as business_avatar,email,address,social_links,category_id,latitude,longitude','business.reviews.user')
            ->select('id', 'category_name')
            ->where('category_type', 'business')
            ->get();
        return apiSuccessMessage('Business', BusinessCategoriesResource::collection($categories));
    }
}
