<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $payload = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:5'],
        ]);

        
        $user = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => bcrypt($payload['password']), 
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
     
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        
        $user = User::findOrFail($id);

     
        $payload = $request->validate([
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email', "unique:users,email,{$id}"],
            'password' => ['nullable', 'string', 'min:5'],
        ]);

        $user->update(array_filter([
            'name' => $payload['name'] ?? $user->name,
            'email' => $payload['email'] ?? $user->email,
            'password' => isset($payload['password']) ? bcrypt($payload['password']) : $user->password,
        ]));

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ], 200);
        
    

    }

    public function destroy($id)
    {

        try {

            $user = User::findOrFail($id);
    
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
    
        } catch (\Exception $e) {
            // Diğer hatalar
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
        }

}
