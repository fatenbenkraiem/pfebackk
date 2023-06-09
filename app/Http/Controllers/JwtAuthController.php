<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class JwtAuthController extends Controller
{
      //Azert@1452@56
    
      /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function registeruser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'role' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->nom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role'=>$request->role
            ]);
            $token = $user->createToken('myapptoken')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' =>  $token 
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'user'=>$user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
 /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
         
        $user = User::find(auth('sanctum')->user()->id)->firstOrFail();
        return response()->json($user);
    }
       public function update(Request $request)
    {
        $user = Auth::User();

        $validatedData = $request->validate([
            'cppassword' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($validatedData['cppassword'], $user->password)) {
            return response()->json(['errors' => ['cppassword' => ['Current password is incorrect']]], 422);
        }

        $user->password = Hash::make($validatedData['password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }

  
 /**
     * Get the authenticated User.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
 
    public function logout(  )

    {     $user = User::find(auth('sanctum')->user()->id)->firstOrFail();
        $user->tokens()->delete();
     return response()->json(['message' => 'Logout  successfully']);

    }
    public function findByUsername($nom)
{
    return $this->where('username', $nom)->first();
}



}
