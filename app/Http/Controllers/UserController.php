<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiHttpResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    use ApiHttpResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        // $users = User::with('roles')->latest()->get();
        $data = UserResource::collection($users);
        $message = 'successful';
        return $this->sendSuccess($data,  $message, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'min:11', 'max:13'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $data = [
                'user' => new UserResource($user),
                'token' => $user->createToken('Registration api token for ' . $user->name)->plainTextToken,
            ];

        $message = 'registration successful';
        return $this->sendSuccess($data,  $message, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // hoe to load the user with the user
        // $user = user::with('user');
        $data = new UserResource($user);
        $message = 'successful';
        return $this->sendSuccess($data,  $message, 200);

    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'min:5'],
            'phone_number' => ['nullable', 'min:11', 'max:13'],
        ]);
        $user->title = $validated['name']?? $user->name;
        $user->body = $validated['phone_number']?? $user->phone_number;
        $user->save();

        $data = new UserResource($user);
        $message = "update successful";
        return $this->sendSuccess($data,  $message, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $data = [];
        $message = "user deleted successful";
        return $this->sendSuccess($data,  $message, 202);

    }
}
