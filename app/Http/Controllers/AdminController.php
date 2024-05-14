<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware("role:admin");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('roles:name')->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::create($request->validated());

        $user->assignRole($request->type);

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserRequest $request, User $user)
    {
        foreach ($request->validated() as $field => $value) {
            $user->{$field} = $value;
        }
        $user->save();
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $post_repository = new PostRepository();
        $posts = $post_repository->getByUser($user);

        foreach ($posts as $post)
        {
            $post->update([
                'user_id' => null,
                'archived' => true
            ]);
        }

        $user->delete();

        return response()->json([
            'message' => 'ok!'
        ]);
    }
}
