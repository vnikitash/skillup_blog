<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class PostController extends Controller
{
    public function index(Request $request): View
    {

        $user = $request->user();

        $collection = Post::with(['user'])->get();




        return view('index', [
            'posts' => $collection->map(function (Post $post) use ($user) {
                $post->likesCount = $post->likes->count();
                $post->liked = false;

                if ($user) {
                    foreach ($post->likes as $like) {
                        if ($like->user_id === $user->id) {
                            $post->liked = true;
                        }
                    }
                }

                return $post;
            })
        ]);
    }

    public function store(CreatePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $post = new Post();
        $post->text = $validated['comment'];
        $post->user_id = $request->user()->id;
        $post->save();

        $post->load('user');

        return response()
            ->json(
                ['data' => $post],
                Response::HTTP_CREATED
            );
    }

    public function setLike(int $postId, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $like = Like::query()
            ->where('post_id', $postId)
            ->where('user_id', $user->id)
            ->first();

        if (!$like) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $postId;
            $like->save();

            return response()->json(['status' => true], Response::HTTP_CREATED);
        }

        $like->delete();

        return response()->json(['status' => true], Response::HTTP_ACCEPTED);
    }
}