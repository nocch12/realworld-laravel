<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\FeedRequest;
use App\Http\Requests\Article\ListRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\UseCases\Article\DeleteAction;
use App\UseCases\Article\FeedAction;
use App\UseCases\Article\ListAction;
use App\UseCases\Article\StoreAction;
use App\UseCases\Article\UpdateAction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except([
            'list',
            'show',
        ]);
    }

    /**
     * 記事一覧
     *
     * @param ListRequest $request
     * @param ListAction $action
     * @return AnonymousResourceCollection
     */
    public function list(ListRequest $request, ListAction $action): AnonymousResourceCollection
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

    public function feed(FeedRequest $request,  FeedAction $action): AnonymousResourceCollection
    {
        $list = $action(
            $request->validated('limit', 20),
            $request->validated('offset', 0),
        );

        return ArticleResource::collection($list);
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    public function store(StoreRequest $request, StoreAction $action)
    {
        $article = $action($request->makeArticle(), $request->makeTags());
        return new ArticleResource($article);
    }

    public function update(UpdateRequest $request, Article $article, UpdateAction $action)
    {
        $this->authorize('update', $article);
        $article = $action($request->makeArticle($article));
        return new ArticleResource($article);
    }

    public function destroy(Article $article, DeleteAction $action)
    {
        $this->authorize('delete', $article);
        return $action($article);
    }
}
