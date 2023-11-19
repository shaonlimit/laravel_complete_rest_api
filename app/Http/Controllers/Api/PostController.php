<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\SuccessResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return new SuccessResource([
            'data' => $posts,
        ]);
    }
    public function store(StorePostRequest $request)
    {
        $data = $request->all();

        if (array_key_exists('image', $data)) {

            $data['image'] = Storage::putFile('images/posts', $data['image']);
        }

        $post = Post::create($data);


        return (new SuccessResource(['message' => 'Post Created Successfully', 'data' => $post]))->response()->setStatusCode(201);
    }
    public function show(Post $post)
    {
        // $formatData['data'] = new CategoryResource($category);
        // return new SuccessResource([
        //     'data' => $formatData,
        // ]);

        return new SuccessResource([
            'data' => $post,
        ]);
    }
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->all();


        if (array_key_exists('image', $data)) {
            Storage::delete($post->image);
            $data['image'] = Storage::putFile('', $data['image']);
        }

        $post->update($data);


        return (new SuccessResource(['message' => 'Post updated Successfully', 'data' => $post]))->response()->setStatusCode(201);
    }
    public function destroy(Post $post)
    {
        Storage::delete($post->image);
        $post->delete();
        return new SuccessResource([
            'message' => 'Post Deleted',
            'data' => $post,
        ]);
    }
}
