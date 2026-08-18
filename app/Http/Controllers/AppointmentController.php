<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DepartmentHasItem;
use App\Models\Member;
use App\Models\DepartmentMember;
use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppointmentController extends Controller
{
    public function create()
    {
        $departments = DepartmentHasItem::where('has_appointment', true)
            ->where('is_active', true)
            ->get();

        // Prepare nested array: department_id => doctors
        $departmentDoctors = [];
        foreach ($departments as $dept) {
            $members = $dept->members()->wherePivot('is_active', 1)->get();
            $departmentDoctors[(string)$dept->id] = $members->map(function ($m) {
                return ['id' => $m->id, 'name' => $m->name];
            })->toArray();
        }

        $pageName = "Book Appointment";

        return view('web.appointments.create', compact('pageName','departments', 'departmentDoctors'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Your appointment has been booked successfully!')
            ->with('appointment_code', $appointment->appointment_code);
    }

    public function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $apiKey = env('ABSTRACT_API_KEY');

        $emailCheck = Http::get('https://emailvalidation.abstractapi.com/v1/', [
            'api_key' => $apiKey,
            'email' => $request->email,
        ]);

        if (!$emailCheck->ok() || !$emailCheck['is_valid_format']['value'] || $emailCheck['deliverability'] !== 'DELIVERABLE') {
            return response()->json([
                'valid' => false,
                'message' => 'This email address appears to be invalid or undeliverable.'
            ]);
        }

        return response()->json(['valid' => true]);
    }
}
