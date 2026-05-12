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

    // Company Visit Methods
    public function companyVisit()
    {
        $benefits = $this->getCompanyVisitBenefits();
        $description = $this->getCompanyVisitDescription();
        $faqs = $this->getCompanyVisitFaqs();
        $googleFormUrl = 'YOUR_GOOGLE_FORM_URL'; // Replace with actual Google Form URL
        
        return view('sections.company-visit', compact('benefits', 'description', 'faqs', 'googleFormUrl'));
    }

    private function getCompanyVisitBenefits()
    {
        return [
            'First-hand exposure to the oil and gas and energy industry',
            'Insights and knowledge about the energy and industrial sector',
            'Opportunity to learn how sustainability and innovation are applied in real industrial practices',
            'Opportunity to apply academic knowledge to real-world industrial contexts',
            'Opportunity to have direct discussions with industry experts',
            'Networking opportunities and valuable professional connections',
            'E-certificate of participation',
            'Social media exposure',
            'One main meal and one snack provided',
            'Round-trip transportation from Semarang to Balongan by 50-seat bus'
        ];
    }

    private function getCompanyVisitDescription()
    {
        return 'Pertamina Refinery Unit VI (RU VI) Balongan is one of PT Pertamina\'s strategic refining facilities located in Indramayu, West Java. The refinery plays a vital role in supporting Indonesia\'s national energy supply, particularly in meeting the growing demand for high-quality fuel and petroleum products. Guided by the spirit of Energy for the Nation, Pertamina RU VI Balongan is committed to strengthening Indonesia\'s energy security while promoting sustainable industrial development. The refinery operates with international standards and continuously adopts modern technologies and digitalized processes to enhance efficiency, reliability, and safety in its operations. Beyond its role in energy production, Pertamina RU VI Balongan also demonstrates a strong commitment to environmental protection, occupational safety, and community development. Through continuous innovation and sustainable practices, the refinery strives to create long-term value not only for the energy sector, but also for society and the surrounding environment. As one of the key national strategic assets, Pertamina RU VI Balongan stands as a symbol of Indonesia\'s progress toward a more resilient, independent, and sustainable energy future.';
    }

    private function getCompanyVisitFaqs()
    {
        return [
            [
                'question' => 'What is Company Visit Inception 2026?',
                'answer' => 'Company Visit: "From Classroom to Industry: Preparing Future Leaders for Energy Sustainability" is the main program in the INCEPTION 2026 series, designed to provide students with firsthand experience in getting to know the professional world of the oil and gas industry and the energy sector comprehensively. Through visits to energy companies, participants will gain an in-depth understanding of operational practices, work culture, technological innovations, and the challenges faced by the industry in promoting the transition to sustainable energy. This activity includes presentations from company representatives, tours of relevant facilities or departments, and interactive discussion sessions that bridge academic theory with real-world applications. Open to students interested in oil and gas, renewable energy, industrial technology, the environment, management, and sustainable development, this program not only enriches their knowledge but also fosters critical thinking, innovative spirit, and professional readiness—empowering the younger generation to become future leaders who play an active role in realizing a responsible, efficient, and sustainable energy system.'
            ],
            [
                'question' => 'When and where will the event be held?',
                'answer' => 'PT Kilang Pertamina Internasional (Unit RU VI Balongan)'
            ],
            [
                'question' => 'Who can participate in this event?',
                'answer' => 'All students of Diponegoro University'
            ],
            [
                'question' => 'Will participants receive a certificate?',
                'answer' => 'Yes, all participants will receive an e-certificate, which will be distributed after the company visit is completed.'
            ],
            [
                'question' => 'What should participants bring?',
                'answer' => '<strong>Required Items:</strong><br>
• Personal identification (ID card or student card)<br>
• University Jacket (almamater)<br>
• Proper safety attire: long pants, closed shoes, and a shirt<br>
• Personal necessities (medication, drinking water, and light snacks)<br>
• Notebook and stationery<br><br>
<strong>Recommended Items:</strong><br>
• Power bank<br>
• Personal protective items (mask or hand sanitizer)<br>
• Cap (only worn during company tours)<br><br>
<strong>Prohibited Items:</strong><br>
• Cigarettes and lighters<br>
• Sharp objects<br>
• Flammable materials'
            ],
            [
                'question' => 'How does the registration process work?',
                'answer' => 'The registration process is conducted online through a Google Form provided by the organizing committee. Participants are required to fill in and upload the required information and documents, including:<br>
• Students of Diponegoro University<br>
• Full name<br>
• Student ID Numbert<br>
• Faculty<br>
• Study Program<br>
• Class of [Year]<br>
• Student ID Card<br>
• Proof of Payment<br>
• Wearpack size (S, M, L, XL, XXL)<br>
• Shoe size<br><br>
After completing the registration, participants will be added to a group chat with fellow participants. All further information, announcements, and reminders regarding the event will be shared through this group.'
            ],
            [
                'question' => 'Will transportation be provided by the organizing committee?',
                'answer' => 'Yes, transportation will be provided by the organizing committee. Participants will be transported using buses for both the departure and return trips.'
            ],
            [
                'question' => 'Will meals be provided for the participants?',
                'answer' => 'Yes, meals will be provided for all participants. The organizing committee will provide both main meals and snacks during the event.'
            ]
        ];
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
                'link' => route('company-visit')
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