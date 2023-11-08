<?php

namespace App\Http\Controllers\Api\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchBusinessRequest;
use App\Models\User;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function getBusiness(Request $request)
    {
        $range = $request->range??40;
        $business = User::select('id',
                                'business_name',
                                'avatar as business_avatar',
                                'email',
                                'address',
                                'category_id',
                                'latitude',
                                'longitude',
                                )
            ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                            cos( radians( latitude ) )
                            * cos( radians( longitude ) - radians(?)
                            ) + sin( radians(?) ) *
                            sin( radians( latitude ) ) )
                        ) AS distance', [$request->latitude, $request->longitude, $request->latitude])
            ->having('distance', '<', $range)
            ->where('role', 'business')
            ->get();

        return apiSuccessMessage("Businesses",$business);

    }

    public function searchBusiness(SearchBusinessRequest $request) {
        
        $business = User::select('id',
                                'business_name',
                                'avatar as business_avatar',
                                'email',
                                'address',
                                'category_id',
                                'latitude',
                                'longitude',
                                )
            ->where('business_name', 'LIKE', "%$request->key_word%")
            ->where(['role' => 'business' , 'category_id' => $request->category_id])
            ->get();
            
        return apiSuccessMessage("Businesses",$business);
    }
}
