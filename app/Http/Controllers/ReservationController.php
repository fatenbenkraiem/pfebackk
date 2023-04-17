<?php

namespace App\Http\Controllers;


use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\reservations;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReservationController extends Controller
{
    /*public function stepOne(Request $request)
    {
        $reservation = $request->get('reservation');
        $min_date = Carbon::today();
        $max_date = Carbon::now()->addWeek();
        return  response(json_encode([
            "message" => "succefully maj",
            "statut" => 202
        ]), 202);
    }
    public function stepTwo(Request $request)
    {
        $reservation = $request->get('reservation');
        $res_ids = Reservation::orderBy('date_debut'&&'date_fin')->get()->filter(function ($value) use ($reservation) {
            return $value->date_debut->format('Y-m-d') == $reservation->date_debut->format('Y-m-d');
        })->pluck('ressources_id');
        $ressources = Ressources::where('etat', RessourcesStatus::Avalaiable)
            ->whereNotIn('id', $res_ids)->get();
         return response(json_encode([
            "message" => "succefully updated",
            "statut" => 202
        ]), 202);
    }*/

    /**
     * Create a new reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function addReservation(Request $request, $id,$iduser)
    {
      
        // Validate request data
        $validatedData = $request->validate([
            'datedebut' => 'required',
            'datefin' => 'required',
            'etat'=>'required',

            // Add any other validation rules you need for the reservation fields
        ]);
    
    
        
        // Create new reservation
        $reservation = new Reservations();
        $reservation->datedebut = $validatedData['datedebut'];
        $reservation->datefin = $validatedData['datefin'];
        $reservation->etat=$validatedData['etat'];
        // Set any other fields you need for the reservation
        $reservation->user_id=$iduser;
        $reservation->ressources_id=$id;
        $reservation->save();

        // Return success response
        return response()->json(['message' => 'Reservation created successfully']);
    }
    /**
     * Update a reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateReservation(Request $request, $id,$idres)
    {
        // Find reservation
        $reservation = Reservations::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        // Validate request data
        $validatedData = $request->validate([
            'datedebut' => 'required|date',
            'datefin' => 'required|date|after:datedebut',
            'etat'=> 'required'
            // Add any other validation rules you need for the reservation fields
        ]);
        

        // Update reservation
            $reservation->datedebut = $validatedData['datedebut'];
            $reservation->etat = $validatedData['etat'];
            $reservation->datefin = $validatedData['datefin'];
        // Set any other fields you need for the reservation
        $reservation->ressources_id=$idres;
        $reservation->save();

        // Return success response
        return response()->json(['Reservation' => $reservation]);
    }

    /**
     * Delete a reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteReservation($id)
    {
        // Find reservation
        $reservation = Reservations::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        // Delete reservation
        $reservation->delete();

        // Return success response
        return response()->json(['Reservation' => $reservation]);
    }

    /**
     * Find a reservation by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findReservation($id)
    {
        // Find reservation
        $reservation = Reservations::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        // Return reservation data
        return response()->json($reservation);
    }
    public function index()
    {
        return Reservations::all();    
    }
    
}

   
