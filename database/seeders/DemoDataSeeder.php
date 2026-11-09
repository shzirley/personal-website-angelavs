<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

// Faker data for the pagination demo. Archived, so it never reaches the public site.
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory(30)->create(['is_active' => false]);
    }
}
