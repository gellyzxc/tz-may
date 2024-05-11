<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    private $repository;

    public function __construct()
    {
        $this->middleware('role:admin,writer')->only([
            'update', 'store', 'destroy'
        ]);

        $this->repository = new PostRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->repository->with('user:id,name')->where('archived', false)->paginate(20);
        return response()->json($data);
    }

    public function my()
    {
        $data = $this->repository->getByUser(Auth::user());
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $post = $this->repository->create([...$request->validated(), 'user_id' => Auth::id()]);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $data = $this->repository->getById($post->id)->load('user:id,name');
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $this->repository->updateById($post->id, $request->validated());
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $data = $this->repository->deleteById($post->id);
        return response()->json([
            'message' => 'ok!'
        ]);
    }
}
