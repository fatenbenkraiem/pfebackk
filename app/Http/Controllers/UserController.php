<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
  
     /**
     * Store a newly created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return User::create($request->all());
    }
     /**
     * Add a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addUser(Request $request)
    {
        // Validate input data
        $this->validate($request, [
            'nom' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

              // Create new user
    $user = new User();

       $user->nom = $request->input('nom');
       $user->email = $request->input('email');
       $user->tel = $request->input('tel');
       $user->role = $request->input('role');
       $user->password = bcrypt($request->input('password'));
       
       $user->save();


        // Return success response
        return response()->json(['User' => $user], 201);
    }
     
    /**
     * Update a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {
        // Validate input data
        $this->validate($request, [
            'nom' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
            'role' => 'required',
        ]);

        // Find user
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update user
        $user->nom = $request->input('nom');
        $user->email = $request->input('email');
        if($request->has('tel')){
            $user->tel=$request->input('tel');
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        // Return success response
        return response()->json(['User' => $user]);
    }

    /**
     * Find a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findUser($id)
    {
        // Find user
        
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return user data
        return $user;
    }
    /**
 * Delete a user.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function deleteUser($id)
{
    // Find user
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }


    // Delete user
    $user->delete();

    // Return success response
    return response()->json(['User' => $user]);
}
  public function index()
    {
        return User::all();    
    }
}

