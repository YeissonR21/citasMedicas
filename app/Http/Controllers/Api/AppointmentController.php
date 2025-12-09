<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Appointment::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =$request->validate([
            'patient_name'=>'required|string|max:255',
            'doctor_name'=>'required|string|max:255',
            'date'=>'required|date|date_format:Y-m-d',
            'time'=>'required|date_format:H:i',
            'reason'=>'nullable|string',
            'status'=>'required|in:pendiente,realizada,cancelada'
        ]);
        return Appointment::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(appointment $appointment)
    {
        return $appointment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Appointment $appointment)
    {
        $data =$request->validate([
            'patient_name'=>'required|string|max:255',
            'doctor_name'=>'required|string|max:255',
            'date'=>'required|date|date_format:Y-m-d',
            'time'=>'required|date_format:H:i',
            'reason'=>'nullable|string',
            'status'=>'required|in:pendiente,realizada,cancelada'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['message' => 'Cita eliminada correctamente']);
    }
}
