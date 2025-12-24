<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategoriOptions = [
            User::KATEGORI_BUSINESS_CASE,
            User::KATEGORI_GEOTHERMAL,
            User::KATEGORI_POSTER_PAPER,
            User::KATEGORI_WELL_STIMULATION,
        ];

        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'peserta',
            'nama_tim' => fake()->company(),
            'kategori_lomba' => fake()->randomElement($kategoriOptions),
            'foto' => null,
            'status_verifikasi' => fake()->randomElement(['pending', 'verified']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'nama_tim' => null,
            'kategori_lomba' => null,
            'status_verifikasi' => 'verified',
        ]);
    }

    /**
     * Indicate that the user is a peserta.
     */
    public function peserta(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'peserta',
        ]);
    }

    /**
     * Set specific kategori lomba.
     */
    public function kategori(string $kategori): static
    {
        return $this->state(fn (array $attributes) => [
            'kategori_lomba' => $kategori,
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
}
