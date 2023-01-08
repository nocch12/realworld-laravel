<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\ListRequest;
use App\Http\Resources\ArticleResource;
use App\UseCases\Article\ListAction;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function list(ListRequest $request, ListAction $action)
    {
        $list = $action(
            $request->validated('tag'),
            $request->validated('author'),
            $request->validated('favorited'),
            $request->validated('limit', 20),
            $request->validated('offset', 0),
        );

        return ArticleResource::collection($list);
    }
}
