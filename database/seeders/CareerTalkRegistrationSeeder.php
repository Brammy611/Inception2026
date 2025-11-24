<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CareerTalkRegistration;
use Faker\Factory as Faker;

class CareerTalkRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Clear existing registrations (optional)
        $this->command->warn('Clearing existing registrations...');
        CareerTalkRegistration::truncate();
        
        $institutions = [
            'Universitas Diponegoro',
            'Universitas Gadjah Mada',
            'Institut Teknologi Bandung',
            'Universitas Indonesia',
            'Institut Teknologi Sepuluh Nopember',
            'Universitas Brawijaya',
            'Universitas Airlangga',
        ];

        $majors = [
            'Teknik Perminyakan',
            'Teknik Kimia',
            'Teknik Mesin',
            'Teknik Elektro',
            'Teknik Industri',
            'Teknik Sipil',
            'Teknik Informatika',
            'Fisika Teknik',
        ];

        $statuses = ['pending', 'confirmed', 'attended', 'cancelled'];
        $statusWeights = [30, 40, 20, 10]; // Percentage distribution

        $motivations = [
            'Saya ingin mengetahui lebih dalam tentang industri energi dan peluang karir di dalamnya. Career Talk ini adalah kesempatan yang sangat baik untuk belajar dari para profesional berpengalaman.',
            'Sebagai mahasiswa teknik perminyakan, saya sangat tertarik untuk mendengar pengalaman langsung dari praktisi industri. Saya berharap dapat memperoleh insight berharga untuk pengembangan karir saya.',
            'Saya ingin memperluas networking dengan profesional di bidang energi dan teknologi. Selain itu, saya juga ingin mengetahui keterampilan apa saja yang dibutuhkan untuk sukses di industri ini.',
            'Career Talk ini sangat relevan dengan jurusan yang saya ambil. Saya ingin mengetahui trend terkini di industri energi dan bagaimana saya dapat mempersiapkan diri untuk menghadapi tantangan di masa depan.',
            'Saya tertarik untuk mengetahui lebih banyak tentang transisi energi dan peran teknologi dalam industri modern. Saya berharap dapat belajar banyak dari para pembicara yang berpengalaman.',
        ];

        $this->command->info('Creating 50 sample registrations...');
        $progressBar = $this->command->getOutput()->createProgressBar(50);
        $progressBar->start();

        // Generate 50 sample registrations with transaction
        DB::transaction(function () use ($faker, $institutions, $majors, $statuses, $statusWeights, $motivations, $progressBar) {
            for ($i = 0; $i < 50; $i++) {
                try {
                    // Select status based on weights
                    $rand = rand(1, 100);
                    $cumulative = 0;
                    $selectedStatus = 'pending';
                    
                    foreach ($statuses as $index => $status) {
                        $cumulative += $statusWeights[$index];
                        if ($rand <= $cumulative) {
                            $selectedStatus = $status;
                            break;
                        }
                    }

                    // Random date between 30 days ago and now
                    $createdAt = $faker->dateTimeBetween('-30 days', 'now');

                    $registration = CareerTalkRegistration::create([
                        'full_name' => $faker->name,
                        'email' => $faker->unique()->safeEmail,
                        'phone' => '08' . $faker->numerify('##########'),
                        'institution' => $faker->randomElement($institutions),
                        'major' => $faker->randomElement($majors),
                        'semester' => (string) $faker->numberBetween(1, 8),
                        'motivation' => $faker->randomElement($motivations),
                        'status' => $selectedStatus,
                        'email_sent' => $faker->boolean(80), // 80% emails sent
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);

                    // Set confirmed_at for confirmed and attended registrations
                    if ($selectedStatus === 'confirmed' || $selectedStatus === 'attended') {
                        $registration->confirmed_at = $faker->dateTimeBetween($registration->created_at, 'now');
                        $registration->save();
                    }

                    // Set attended_at for attended registrations
                    if ($selectedStatus === 'attended') {
                        $confirmedAt = $registration->confirmed_at ?? $registration->created_at;
                        $registration->attended_at = $faker->dateTimeBetween($confirmedAt, 'now');
                        $registration->save();
                    }

                    $progressBar->advance();
                    
                    // Small delay to ensure unique registration numbers
                    usleep(10000); // 0.01 second delay
                    
                } catch (\Exception $e) {
                    $this->command->error("\nError creating registration #{$i}: " . $e->getMessage());
                    continue;
                }
            }
        });

        $progressBar->finish();
        $this->command->newLine();
        $this->command->info('✓ 50 Career Talk registrations created successfully!');
        
        // Show statistics
        $this->command->newLine();
        $this->command->table(
            ['Status', 'Count'],
            [
                ['Pending', CareerTalkRegistration::where('status', 'pending')->count()],
                ['Confirmed', CareerTalkRegistration::where('status', 'confirmed')->count()],
                ['Attended', CareerTalkRegistration::where('status', 'attended')->count()],
                ['Cancelled', CareerTalkRegistration::where('status', 'cancelled')->count()],
                ['TOTAL', CareerTalkRegistration::count()],
            ]
        );
    }
}