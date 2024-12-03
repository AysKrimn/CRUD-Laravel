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

        try {
            $payload = $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:5'],
            ]);
    
            // Kullanıcı oluşturma
            $user = User::create([
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => bcrypt($payload['password']),
            ]);
    
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e
            ], 422);
        }
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
    public function update(Request $request, User $user)
    {

        try {

            $payload = $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:5'],
            ]);


        $user->update([
              'name' => $payload['name'],
              'email' => $payload['email'],
              'password' => bcrypt($payload['password']),
        ]);

        return response()->json($user);
        
    } catch(Exception $e) {

        return response()->json([
            'message' => 'Validation Error',
            'errors' => $e
        ], 422);
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        try {
            
            $user->delete();
            return response()->json(null, 204);

        } catch(Exception $e) {

            return response()->json([
                'message' => 'Unable to perform your request',
                'errors' => $e
            ], 422);

        }
       

    
    }
}
