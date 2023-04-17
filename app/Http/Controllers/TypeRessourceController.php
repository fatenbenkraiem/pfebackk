<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\typeRessources;

class TypeRessourceController extends Controller
{
    public function index()
    {
        return typeRessources::all();    
    }

    public function addTypeRessource(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'nom' => 'required',
            'quantites' => 'required|integer',
        

            // Add any other validation rules you need for the reservation fields
        ]);
               
        // Create new typeressources
        $typeressources = new TypeRessources();
        $typeressources->nom = $validatedData['nom'];
        $typeressources->quantites =$validatedData['quantites'];
        // Set any other fields you need for the typrressources
        //return $typeressources;
        
        $typeressources->save();

        // Return success response
        return response()->json(['Type Ressources' => $typeressources]);
    }
     /**
     * Update a reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTypeRessource(Request $request, $id)
    {
        
        // Find reservation
        $typeressources = TypeRessources::find($id);
        if (!$typeressources) {
            return response()->json(['Message' => 'Type Ressources not found'], 404);
        }

        // Validate request data
        $validatedData = $request->validate([
            'nom' => 'required',
            'quantites'=> 'required|integer'
            // Add any other validation rules you need for the type ressources fields
        ]);
        

        // Update ressources
         $typeressources->nom = $validatedData['nom'];
         $typeressources->quantites =$validatedData['quantites'];
        // Update any other fields you need for the type ressources
         $typeressources->save();

        // Return success response
        return response()->json(['Type Ressources' => $typeressources]);
    }

    /**
     * Delete a type ressources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTypeRessource($id)
    {
        // Find type ressources
        $typeressources = TypeRessources::find($id);
        if (!$typeressources) {
            return response()->json(['message' => 'Type Ressources not found'], 404);
        }

        // Delete type ressources
        $typeressources->delete();

        // Return success response
        return response()->json(['Type Ressources ' => $typeressources]);
    }

    /**
     * Find a Type ressources by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findTypeRessource($id)
    {
        // Find type ressources
        $typeressources = TypeRessources::find($id);
        if (!$typeressources) {
            return response()->json(['message' => 'Type Ressources not found'], 404);
        }

        // Return type ressources data
        return response()->json($typeressources);
    }

}
