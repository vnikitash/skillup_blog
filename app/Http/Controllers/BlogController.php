<?php


namespace App\Http\Controllers;

use App\Http\Requests\Blog\CreateBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class BlogController extends Controller
{
    public function index(Request $request): View
    {

        $user = $request->user();

        $blogs = Blog::query()
        ->orderBy('updated_at', 'DESC')
        ->get()
        ->toArray();

        return view('blogs', [
            'blogs' => $blogs,
            'userEmail' => $user->email ?? null
        ]);
    }

    public function show($blogId): JsonResponse
    {
        $blog = Blog::query()
            ->where('id', '=', $blogId)
            ->first();

        if (!$blog) {
            return response()->json(['error' => 'Blog not found with ID: ' . $blogId], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $blog]);
    }

    public function store(CreateBlogRequest $request)
    {
        /** @var User|null $user */
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'You should be authorized to create post!'], Response::HTTP_UNAUTHORIZED);
        }

        $validated = $request->validated();

        $blog = new Blog();
        $blog->user_id = $user->id;
        $blog->title = $validated['title'];
        $blog->text = $validated['text'];
        $blog->save();

        return redirect('/blogs');
    }

    public function update(UpdateBlogRequest $request, $blogId): JsonResponse
    {
        $blog = Blog::query()
            ->where('id', '=', $blogId)
            ->first();

        if (!$blog) {
            return response()->json(['error' => 'Blog not found with ID: ' . $blogId], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validated();

        $blog->title = $validated['title'] ?? $blog->title;
        $blog->text = $validated['text'] ?? $blog->text;
        $blog->save();

        return response()->json(['data' => $blog], Response::HTTP_ACCEPTED);
    }

    public function destroy($blogId): JsonResponse
    {
        $blog = Blog::query()
            ->where('id', '=', $blogId)
            ->first();

        if (!$blog) {
            return response()->json(['error' => 'Blog not found with ID: ' . $blogId], Response::HTTP_NOT_FOUND);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog [' . $blogId . '] has been removed!'], Response::HTTP_ACCEPTED);
    }
}