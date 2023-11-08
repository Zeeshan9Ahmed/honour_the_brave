<?php

namespace App\Http\Controllers\Api\Business\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function addReview (AddReviewRequest $request) {
        
        Review::updateOrCreate( ['user_id' => auth()->id(),'business_id' => $request->business_id],['review' => $request->review]);
        return commonSuccessMessage("Success");
    }
}
