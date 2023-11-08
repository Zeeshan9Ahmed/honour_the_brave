<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index () {
        $reviews = Review::with('user')->where('business_id', auth()->id())->get();
        return view('web.business.reviews.index', compact('reviews'));
    }
}
