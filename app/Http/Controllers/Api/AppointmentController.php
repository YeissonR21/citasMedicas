<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::all();
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'patient_name' => 'required|string|max:255',
                'doctor_name'  => 'required|string|max:255',
                'date'         => 'required|date',
                'time'         => 'required|date_format:H:i',
                'reason'       => 'nullable|string',
                'status'       => 'required|in:pendiente,realizada,cancelada',
            ],
             ['patient_name.required' => 'Es obligatorio el nombre del paciente.',
                'doctor_name.required'  => 'El nombre del doctor es obligatorio.',
                'date.required'         => 'Debe poner una fecha.',
                'date.date'             => 'La fecha debe tener el formato válido.',
                'time.required'         => 'Debe poner una hora.',
                'status.required'       => 'El estado es obligatorio.',
                'status.in'             => 'El estado debe ser pendiente, realizada o cancelada.', ]);

            $appointment = Appointment::create($data);

            return response()->json($appointment, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'error' => 'La cita no existe'
            ], 404);
        }

        return $appointment;
    }

    public function update(Request $request, $id)
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                return response()->json(['error' => 'Cita inexistente'], 404);
            }

            $data = $request->validate([
                'patient_name' => 'sometimes|required|string|max:255',
                'doctor_name'  => 'sometimes|required|string|max:255',
                'date'         => 'sometimes|required|date',
                'time'         => 'sometimes|required',
                'reason'       => 'nullable|string',
                'status'       => 'sometimes|required|in:pendiente,realizada,cancelada',
         ]   );

            $appointment->update($data);

            return response()->json($appointment, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error',
            ], 500);
        }
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'error' => 'La cita no existe'
            ], 404);
        }

        $appointment->delete();

        return response()->json(['message' => 'Cita eliminada correctamente'], 200);
    }
}