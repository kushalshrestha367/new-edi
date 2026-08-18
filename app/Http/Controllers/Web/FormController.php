<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Career\Career;
use App\Models\Career\CareerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\TestPreparation;

class FormController extends Controller
{
    // public function sendEmail(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email',
    //         'contact' => 'required|string|max:20',
    //         'test_id' => 'required|exists:test_preparations,id',
    //     ]);

    //     $data = $request->only(['name', 'email', 'contact', 'test_id']);
    //     $testPreparationData = TestPreparation::findOrFail($data['test_id']);

    //     try {
    //         Mail::send('web.mail.test-preparation', [
    //             'data' => $data,
    //             'testPreparation' => $testPreparationData,
    //         ], function ($message) use ($data, $testPreparationData) {
    //             $message->to('noreply@saphalyaeducation.edu.np')
    //                     ->subject('New ' . $testPreparationData->title . ' Inquiry: ' . $data["name"]);
    //         });

    //         return response()->json(['success' => true]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Mail sending failed.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function careerItemApply(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'cover_letter', 'resume_path']);
        $careerData = Career::where('slug', $slug)->firstOrFail();

        try {
            
            $applicant = CareerApplication::create([
                'career_id' => $careerData->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'cover_letter' => $data['cover_letter'],
                'resume_path' => $data['resume_path']->store('resumes', 'public'),
            ]);

            if ($careerData->need_mail) {
                Mail::send('web.mail.career-organizer', [
                    'data' => $applicant,
                    'careerData' => $careerData,
                ], function ($message) use ($applicant, $careerData) {
                    $message->to($careerData->mail_on)
                            ->subject('New ' . $careerData->title . ' Applicant: ' . $applicant["name"]);
                });
            }

            Mail::send('web.mail.careerApplicant', [
                'data' => $applicant,
                'careerData' => $careerData,
            ], function ($message) use ($applicant, $careerData) {
                $message->to($applicant['email'])
                        ->subject('Applied ' . $careerData->title . ' Successfully. Thank you ' . $applicant["name"]);
            });

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mail sending failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
