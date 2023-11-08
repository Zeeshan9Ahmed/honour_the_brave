<?php

namespace App\Http\Controllers\Api\User\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CoreModule\ContentRequest;
use App\Models\Content;

class IndexController extends Controller
{
    public function content(ContentRequest $request)
    {
        $content = Content::where('slug', $request->slug)->first();
        if (! $content) {
            return commonErrorMessage('No Content Found', 404);
        }

        return apiSuccessMessage('Content', $content);
    }
}
