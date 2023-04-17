<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ressources;
use Validator;

class RessourcesController extends Controller
{
    public function index()
    {
        return Ressources::all();    
    }
    
    public function addRessource(Request $request,$id)
    {
        
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',

            // Add any other validation rules you need for the reservation fields
        ]);
       
        
        
        // Create new ressources
        $ressources = new Ressources();
        $ressources->name = $validatedData['name'];
        $ressources->description = $validatedData['description'];
        $ressources->image=$validatedData['image'];
        // Set any other fields you need for the ressources
        $ressources->type_id=$id;        
        $ressources->save();

        // Return success response
        return response()->json(['ressources' =>$ressources ]);
    }
    /**
     * Update a reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRessource(Request $request, $id)
    {
        
        // Find reservation
        $ressources = Ressources::find($id);
        if (!$ressources) {
            return response()->json(['message' => 'Ressources not found'], 404);
        }

        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description'=> 'required'
            // Add any other validation rules you need for the ressources fields
        ]);
        

        // Update ressources
         $ressources->name = $validatedData['name'];
         $ressources->description = $validatedData['description'];
         $ressources->image=$validatedData['image'];
        // Update any other fields you need for the ressources
         $ressources->save();

        // Return success response
        return response()->json(['Ressources' => $ressources]);
    }

    /**
     * Delete a ressources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRessource($id)
    {
        // Find ressources
        $ressources = Ressources::find($id);
        if (!$ressources) {
            return response()->json(['message' => 'Ressources not found'], 404);
        }

        // Delete ressources
        $ressources->delete();

        // Return success response
        return response()->json(['Ressources' => $ressources]);
    }

    /**
     * Find a ressources by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findRessource($id)
    {
        // Find reservation
        $ressources = Ressources::find($id);
        if (!$ressources) {
            return response()->json(['message' => 'Ressources not found'], 404);
        }

        // Return reservation data
        return response()->json($ressources);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        return view('imageUpload');
    }*/
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
               

       $validator = Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
      if($validator->fails()) {          
            
            return response()->json(['error'=>$validator->errors()], 401);                        
         }
              $imageName = time().'.'.$request->image->extension();  
       
        $request->image->move(public_path('images'), $imageName);
    
        /* 
            Write Code Here for
            Store $imageName name in DATABASE from HERE 
        */
      
        return $imageName;
    }
}

