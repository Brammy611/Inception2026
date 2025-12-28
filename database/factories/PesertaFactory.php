<?php

namespace Database\Factories;

use App\Models\Peserta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peserta>
 */
class PesertaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategoriOptions = [
            Peserta::KATEGORI_BUSINESS_CASE,
            Peserta::KATEGORI_GEOTHERMAL,
            Peserta::KATEGORI_POSTER_PAPER,
            Peserta::KATEGORI_WELL_STIMULATION,
        ];

        $jurusanOptions = [
            'Teknik Perminyakan',
            'Teknik Geologi',
            'Teknik Kimia',
            'Teknik Mesin',
            'Teknik Industri',
        ];

        $univOptions = [
            'Universitas Indonesia',
            'ITB',
            'UGM',
            'ITS',
            'Undip',
            'Unpad',
            'UI',
        ];

        return [
            'user_id' => User::factory(),
            'nama_tim' => fake()->company(),
            'nama_leader' => fake()->name(),
            'asal_univ' => fake()->randomElement($univOptions),
            'jurusan_leader' => fake()->randomElement($jurusanOptions),
            'nama_member_1' => fake()->name(),
            'jurusan_member_1' => fake()->randomElement($jurusanOptions),
            'nama_member_2' => fake()->optional(0.7)->name(),
            'jurusan_member_2' => fake()->optional(0.7)->randomElement($jurusanOptions),
            'kategori' => fake()->randomElement($kategoriOptions),
            'ktm' => null,
            'follow_ig' => null,
            'share_poster' => null,
            'payment' => null,
            'status_verifikasi' => fake()->randomElement(['pending', 'verified']),
        ];
    }

    /**
     * Set specific kategori.
     */
    public function kategori(string $kategori): static
    {
        return $this->state(fn (array $attributes) => [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Set status as verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_verifikasi' => 'verified',
        ]);
    }

    /**
     * Set status as pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_verifikasi' => 'pending',
        ]);
    }

    /**
     * Set status as rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_verifikasi' => 'rejected',
        ]);
    }
}
