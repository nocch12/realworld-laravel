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
        $list = $action();

        return ArticleResource::collection($list);
    }
}
