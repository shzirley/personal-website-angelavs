<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    public static function pages(): array
    {
        return array_map(fn ($path) => [$path], [
            '/', '/mahasiswa/5025241226', '/projects', '/projects/claritas',
            '/projects/tappcom', '/projects/green-saldo',
            '/calculator', '/dashboard', '/dashboard/mahasiswa/5025241226',
            '/contact', '/collection', '/resume',
        ]);
    }

    #[DataProvider('pages')]
    public function test_pages_render_without_errors(string $path): void
    {
        $this->get($path)->assertOk()->assertSee('AngelaOS');
    }

    public function test_profile_uses_the_required_nrp_parameter(): void
    {
        $this->get('/mahasiswa/5025241226')->assertSee('Angela Vania Sugiyono')->assertSee('5025241226');
        $this->get('/about')->assertRedirect(route('mahasiswa.show', '5025241226'));
    }

    public function test_original_resume_is_downloadable(): void
    {
        $this->get('/resume/download')->assertOk()->assertDownload('Angela_Vania_Sugiyono_Resume_2026.pdf');
    }

    public static function missingPages(): array
    {
        return array_map(fn ($path) => [$path], [
            '/mahasiswa', '/mahasiswa/abc', '/mahasiswa/502524122',
            '/mahasiswa/50252412266', '/mahasiswa/1111111111',
            '/dashboard/mahasiswa/abc', '/projects/unknown', '/agent', '/dashboard/agent', '/not-a-page',
        ]);
    }

    #[DataProvider('missingPages')]
    public function test_invalid_and_unknown_profiles_use_the_custom_404(string $path): void
    {
        $this->get($path)->assertNotFound()->assertSee('This file')->assertSee('Back to Home');
    }

    public function test_calculator_handles_valid_numbers_and_boundary_values(): void
    {
        $this->get('/hitung-ipk/3.5/3.8')->assertOk()->assertSee('3.65')->assertSee('7.30');
        $this->get('/hitung-ipk/0/4')->assertOk()->assertSee('2.00');
        $this->get('/hitung-ipk/0/0')->assertOk()->assertSee('0.00');
        $this->get('/hitung-ipk/4/4')->assertOk()->assertSee('4.00')->assertSee('8.00');
        $this->get('/calculator/submit?ip1=3%2C50&ip2=3%2C80')->assertRedirect(route('calculator.result', ['ip1' => '3.50', 'ip2' => '3.80']));
    }

    public static function invalidCalculations(): array
    {
        return array_map(fn ($path) => [$path], [
            '/hitung-ipk/5/3', '/hitung-ipk/-1/3', '/hitung-ipk/abc/3',
            '/hitung-ipk/3/NaN', '/hitung-ipk/3/INF',
            '/calculator/submit?ip1=&ip2=3', '/calculator/submit?ip1[]=3&ip2=3',
        ]);
    }

    #[DataProvider('invalidCalculations')]
    public function test_invalid_calculations_show_inline_errors(string $path): void
    {
        $this->get($path)->assertStatus(422)->assertSee('aria-invalid="true"', false)->assertDontSee('data-result', false);
    }

    public function test_achievements_are_complete_and_sorted_newest_first(): void
    {
        $achievements = config('portfolio.achievements');
        $this->assertCount(8, $achievements);
        $years = array_column($achievements, 'year');
        $sorted = $years;
        rsort($sorted);
        $this->assertSame($sorted, $years);
        $this->get('/collection')->assertSeeInOrder(['BRIN AIDeaNation', 'Datathon RISTEK UI', 'Hult Prize Indonesia', 'Dinus App Competition 11.0', 'DigiHack']);
    }

    public function test_latest_resume_and_claritas_role_are_used(): void
    {
        $this->get('/projects/claritas')->assertSee('Chief Operating Officer (COO)')->assertSee('IDR 17.5M');
        $this->get('/resume')->assertSee('Chief Operating Officer (COO)');
        $this->assertFileExists(public_path('documents/brin-aideanation-2026.pdf'));
    }

    public function test_home_contains_the_terminal_theme_game_and_music_desk(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Switch to midnight terminal')
            ->assertSee('Pop a little')
            ->assertSee('TRACK 11 · ROS')
            ->assertSee('56,000 minutes');
    }

    public function test_all_routes_are_named_and_dashboard_is_grouped(): void
    {
        foreach (Route::getRoutes() as $route) {
            $this->assertNotEmpty($route->getName(), 'Unnamed route: '.$route->uri());
        }
        $this->assertSame('dashboard/mahasiswa/{nrp}', Route::getRoutes()->getByName('dashboard.mahasiswa.show')->uri());
        $this->assertNull(Route::getRoutes()->getByName('agent.show'));
    }
}
