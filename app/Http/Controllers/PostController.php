<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Libraries\ImageKit;
use Illuminate\Http\Request;
use App\Traits\ApiHttpResponse;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    use ApiHttpResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(3);
        // $posts = Post::all();
        // $posts = Post::with('user')->latest()->paginate(3)->get();
        $data = PostResource::collection($posts);
        $message = 'successful';
        return $this->sendSuccess($data,  $message, 200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'image' => ['required', 'image', 'min:1', 'max:100'],
            'title' => ['required', 'min:5'],
            'body' => ['required', 'min:5'],
        ]);

        // Get the file
        $file = $request->file('image');

        // Upload the File
        try{

            $upload = new ImageKit();
            $uploaded_file =  $upload->uploadFile($file, 'images');

        }catch(\Exception $e){

            return $this->sendError([], 'something went wrong', 500);
        }

        // Create a post
        try{

            $post = Post::create([
                'user_id' => random_int(1, 3),
                // 'image' => [
                //     'file_id' => $uploaded_file['fileId'],
                //     'file_url' => $uploaded_file['url'],
                // ],
                'image' => $uploaded_file['url'],
                'title' => $validated['title'],
                'body' => $validated['body'],
            ]);

            // Return the created post
            $data = new PostResource($post);
            $message = 'successful';
            return $this->sendSuccess($data,  $message, 201);

        }catch(\Exception $e){

            $uploaded_file_id = $uploaded_file['fileId'];
            $upload = new ImageKit();
            $delete_uploaded_file = $upload->deleteFile($uploaded_file_id);

            return $this->sendError([], 'something went wrong, post creation fail', 500);

        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // lazy load the post with the user
        // $post = Post::with('user');
        $data = new PostResource($post);
        $message = 'successful';
        return $this->sendSuccess($data,  $message, 200);

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'min:5'],
            'body' => ['nullable', 'min:5'],
        ]);
        $post->title = $validated['title']?? $post->title;
        $post->body = $validated['body']?? $post->body;
        $post->save();

        $data = new PostResource($post);
        $message = "update successful";
        return $this->sendSuccess($data,  $message, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // delete image
        // $post_file_id = $post->image['file_id'];
        // $upload = new ImageKit();
        // $delete_uploaded_file = $upload->deleteFile($post_file_id);

        $post->delete();

        $data = [];
        $message = "post deleted successful";
        return $this->sendSuccess($data,  $message, 202);

    }
}
