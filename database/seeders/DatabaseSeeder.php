<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);

        User::factory()->create(['name' => 'Admin AngelaOS', 'email' => 'admin@angelaos.test'])->assignRole('Admin');
        User::factory()->create(['name' => 'Staf AngelaOS', 'email' => 'staf@angelaos.test'])->assignRole('Staf');

        foreach (config('portfolio.projects') as $slug => $project) {
            Project::create(['slug' => $slug] + $project);
        }

        foreach (config('portfolio.achievements') as $achievement) {
            // Seeders run unguarded, so config's string "id" must be dropped explicitly.
            Achievement::create(Arr::except($achievement, 'id'));
        }

        $this->call(DemoDataSeeder::class);
    }
}
