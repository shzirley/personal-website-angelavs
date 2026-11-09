<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $type = fake()->randomElement(['Sistem Informasi', 'Aplikasi', 'Portal', 'Dashboard', 'Platform']);
        $domain = fake()->randomElement(['Akademik', 'Kesehatan', 'UMKM', 'Kepanitiaan', 'Inventaris', 'Keuangan', 'Beasiswa']);
        $company = fake()->company();

        return [
            'title' => "{$type} {$domain} ".fake()->city(),
            'slug' => fake()->unique()->slug(3),
            'category' => fake()->randomElement(Project::CATEGORIES),
            'role' => fake()->randomElement(['Backend Developer', 'Frontend Developer', 'UI/UX Designer', 'Project Manager']),
            'year' => (string) fake()->numberBetween(2022, 2026),
            'summary' => "Membantu {$company} mengelola data ".strtolower($domain).' secara digital.',
            'description' => "Proyek demo untuk kebutuhan {$company}.",
            'responsibilities' => ['Menyusun kebutuhan sistem.', 'Mengembangkan fitur utama.'],
            'highlight' => 'Data demo',
            'is_active' => fake()->boolean(70),
        ];
    }
}
