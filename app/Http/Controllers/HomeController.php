<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\CareerTalkRegistration;
use App\Mail\CareerTalkConfirmationMail;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Inception 2026';
        $metaDescription = 'Showcase of creativity, innovation, and technology';
        $events = $this->getEvents();
        $organizations = $this->getOrganizations();
        $timeline = $this->getTimeline();
        
        return view('welcome', compact('title', 'metaDescription', 'events', 'organizations', 'timeline'));
    }

    public function about()
    {
        return view('sections.about');
    }

    public function events()
    {
        $events = $this->getEvents();
        return view('sections.events', compact('events'));
    }

    public function competitions()
    {
        return view('sections.competition');
    }

    public function timeline()
    {
        $timeline = $this->getTimeline();
        return view('sections.timeline', compact('timeline'));
    }

    // Career Talk Methods
    public function careerTalk()
    {
        $speakers = $this->getSpeakers();
        $benefits = $this->getBenefits();
        $schedule = $this->getSchedule();
        
        return view('sections.career-talk', compact('speakers', 'benefits', 'schedule'));
    }

    public function careerTalkRegister()
    {
        return view('sections.career-talk-register');
    }

    public function careerTalkRegisterStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:career_talk_registrations,email',
            'phone' => 'required|string|max:20',
            'institution' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'semester' => 'required|string',
            'motivation' => 'required|string|max:1000',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ], [
            'full_name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor WhatsApp harus diisi',
            'institution.required' => 'Asal institusi harus diisi',
            'major.required' => 'Program studi harus diisi',
            'semester.required' => 'Semester harus dipilih',
            'motivation.required' => 'Motivasi harus diisi',
            'motivation.max' => 'Motivasi maksimal 1000 karakter',
            'payment_proof.required' => 'Bukti pembayaran harus diupload',
            'payment_proof.file' => 'File harus berupa gambar atau PDF',
            'payment_proof.mimes' => 'Format file harus JPG, PNG, atau PDF',
            'payment_proof.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle file upload
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $paymentProofPath = $file->storeAs('payment_proofs', $fileName, 'public');
            }

            // Save to database
            $registration = CareerTalkRegistration::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'institution' => $request->institution,
                'major' => $request->major,
                'semester' => $request->semester,
                'motivation' => $request->motivation,
                'payment_proof' => $paymentProofPath,
                'payment_status' => 'pending', // Pending verification
                'status' => 'pending',
            ]);

            // Send confirmation email
            try {
                Mail::to($registration->email)->send(
                    new CareerTalkConfirmationMail($registration)
                );
                
                // Mark email as sent
                $registration->update(['email_sent' => true]);
            } catch (\Exception $e) {
                // Log email error but don't stop the registration
                Log::error('Failed to send confirmation email: ' . $e->getMessage());
            }

            // Store registration number in session for success page
            session(['registration_number' => $registration->registration_number]);

            return redirect()->route('career-talk.success')
                ->with('success', 'Registrasi berhasil! Kami akan mengirimkan konfirmasi ke email Anda.');
                
        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    public function careerTalkSuccess()
    {
        return view('sections.career-talk-success');
    }

    private function getSpeakers()
    {
        return [
            [
                'name'     => 'Ika Prasetyawan B.Eng. M.Sc. Ph.D.',
                'position' => 'Floating Structures Specialist',
                'company'  => 'PETRONAS',
                'image'    => 'ika_prasetyawan.jpg',
                'bio'      => 'Naval Architect and Floating Structures Specialist with over 27 years of experience in the marine and offshore industry, currently providing technical leadership at PETRONAS and serving as a visiting professor.'
            ],
            [
                'name'     => 'Tommi Parnando',
                'position' => 'Head, H.R. Project & Business Improvement',
                'company'  => 'PT. Freeport Indonesia',
                'image'    => 'tommi_parnando.jpg', 
                'bio'      => 'HR professional managing strategic initiatives and business process improvements at PT. Freeport Indonesia. Experienced in Quality Management, Communication, and previously co-founded TrainingZen.'
            ]
        ];
    }

    private function getBenefits()
    {
        return [
            'E-Certificate for all participants',
            'Networking with industry professionals',
            'Career insights from experienced practitioners',
            'Opportunity for interactive Q&A'
        ];
    }

    private function getSchedule()
    {
        return [
            ['time' => '09:30 - 10:00', 'activity' => 'Open Gate'],
            ['time' => '10:00 - 10:10', 'activity' => 'Opening'],
            ['time' => '10:10 - 10:20', 'activity' => 'Opening Remarks from the Project Manager of Inception 2026'],
            ['time' => '10:20 - 10:25', 'activity' => 'Speaker (1) CV Reading'],
            ['time' => '10:25 - 11:10', 'activity' => 'Presentation of Material by Speaker (1)'],
            ['time' => '11:10 - 11:25', 'activity' => 'QnA Session'],
            ['time' => '11:25 - 11:30', 'activity' => 'Certification + Photo Session'],
            ['time' => '11:30 - 11:45', 'activity' => 'Ice Breaking'],
            ['time' => '11:45 - 11:50', 'activity' => 'Speaker (2) CV Reading'],
            ['time' => '11:50 - 12:35', 'activity' => 'Presentation of Material by Speaker (2)'],
            ['time' => '12:35 - 12:50', 'activity' => 'QnA Session'],
            ['time' => '12:50 - 12:55', 'activity' => 'Certification + Photo Session'],
            ['time' => '12:55 - 13:00', 'activity' => 'Closing']
        ];
    }

    private function getEvents()
    {
        return [
            [
                'title' => 'Career Talk',
                'description' => 'Inspirasi langsung dari profesional industri.',
                'image' => 'logo.png',
                'delay' => '0s',
                'link' => route('career-talk')
            ],
            [
                'title' => 'Company Visit',
                'description' => 'Kunjungan eksklusif ke perusahaan.',
                'image' => 'logo.png',
                'delay' => '1s',
                'link' => '#company-visit'
            ],
            [
                'title' => 'Competition',
                'description' => 'Adu kreativitas dalam kompetisi teknologi.',
                'image' => 'logo.png',
                'delay' => '2s',
                'link' => route('competitions')
            ],
            [
                'title' => 'Awarding Night',
                'description' => 'Perayaan puncak peserta.',
                'image' => 'logo.png',
                'delay' => '3s',
                'link' => '#awarding-night'
            ]
        ];
    }

    private function getOrganizations()
    {
        return [
            [
                'name' => 'Society of Petroleum Engineers',
                'short_name' => 'SPE UNDIP SC',
                'badge' => 'Collaboration & Innovation',
                'title' => 'Society of Petroleum Engineers Universitas Diponegoro Student Chapter (SPE UNDIP SC)',
                'description' => 'is a student chapter under SPE International and SPE Java. It is a widely known professional organization based in the Oil and Gas sector. We were established on November 24, 2014, with SC ID 6190.',
                'logo' => 'spelogo.png'
            ],
            [
                'name' => 'Green Future',
                'short_name' => 'SEG Universitas Diponegoro',
                'badge' => 'Collaboration & Innovation',
                'title' => 'Society of Exploration Geophysicists (SEG) Universitas Diponegoro Student Chapter',
                'description' => 'Society of Renewable Energy Undip adalah organisasi mahasiswa yang berfokus pada pengembangan energi terbarukan dan keberlanjutan lingkungan.',
                'logo' => 'seglogo.png'
            ]
        ];
    }

    private function getTimeline()
    {
        return [
            [
                'number' => 1,
                'title' => 'Career Talk',
                'description' => 'Professionals share experiences and insights to inspire participants\' future careers.'
            ],
            [
                'number' => 2,
                'title' => 'Company Visit',
                'description' => 'Exclusive tours of partner companies to explore real-world projects and technologies.'
            ],
            [
                'number' => 3,
                'title' => 'Competition',
                'description' => 'Teams showcase creativity and logic in challenging competitions full of innovation.'
            ],
            [
                'number' => 4,
                'title' => 'Awarding',
                'description' => 'The grand finale - celebrating winners and closing the event with pride and joy.'
            ]
        ];
    }
}