<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminRbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    private function userWithRole(string $role): User
    {
        return User::factory()->create()->assignRole($role);
    }

    private function achievement(array $overrides = []): Achievement
    {
        return Achievement::create($overrides + [
            'year' => 2026, 'title' => 'Finalist', 'event' => 'Lomba Uji', 'organizer' => 'ITS', 'description' => 'Deskripsi',
        ]);
    }

    private function projectData(array $overrides = []): array
    {
        return $overrides + [
            'title' => 'Portal', 'slug' => 'portal', 'category' => Project::CATEGORIES[0], 'role' => 'Dev', 'year' => '2026',
            'summary' => 'Ringkas', 'description' => 'Deskripsi', 'responsibilities' => "Satu\n\n  Dua  ", 'highlight' => 'Sorotan', 'is_active' => '1',
        ];
    }

    public function test_guest_and_user_without_role_cannot_open_the_panel(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
        $this->get('/admin/achievements')->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create())->get('/admin/dashboard')->assertForbidden();
    }

    public function test_login_redirect_depends_on_role(): void
    {
        $this->actingAs($this->userWithRole('Admin'))->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
        $this->actingAs($this->userWithRole('Staf'))->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
        $this->actingAs(User::factory()->create())->get(route('dashboard'))->assertRedirect(route('home'));
    }

    public function test_dashboard_shows_three_database_widgets(): void
    {
        Project::factory()->count(3)->create();
        $this->achievement();

        $this->actingAs($this->userWithRole('Admin'))->get('/admin/dashboard')->assertOk()
            ->assertViewHas('totalProjects', 3)->assertViewHas('totalAchievements', 1)->assertViewHas('totalUsers', 1)
            ->assertSee('Total Proyek')->assertSee('Total Prestasi')->assertSee('Total Pengguna');
    }

    public function test_only_admin_sees_and_can_execute_delete(): void
    {
        $project = Project::factory()->create();
        $achievement = $this->achievement();

        $this->actingAs($this->userWithRole('Staf'))->get('/admin/projects')->assertOk()->assertSee('Edit')->assertDontSee('Hapus');
        $this->get('/admin/achievements')->assertOk()->assertSee('Edit')->assertDontSee('Hapus');
        $this->delete(route('admin.projects.destroy', $project))->assertForbidden();
        $this->delete(route('admin.achievements.destroy', $achievement))->assertForbidden();
        $this->assertModelExists($project);
        $this->assertModelExists($achievement);

        $this->actingAs($this->userWithRole('Admin'))->get('/admin/projects')->assertSee('Hapus');
        $this->delete(route('admin.projects.destroy', $project))->assertRedirect();
        $this->delete(route('admin.achievements.destroy', $achievement))->assertRedirect();
        $this->assertModelMissing($project);
        $this->assertModelMissing($achievement);
    }

    public function test_staf_can_create_and_update_with_validation(): void
    {
        $this->actingAs($this->userWithRole('Staf'));

        $this->post(route('admin.projects.store'), $this->projectData(['is_active' => '0']))->assertRedirect(route('admin.projects.index'));
        $project = Project::where('slug', 'portal')->firstOrFail();
        $this->assertFalse($project->is_active);
        $this->assertSame(['Satu', 'Dua'], $project->responsibilities);

        $this->put(route('admin.projects.update', $project), $this->projectData(['title' => 'Baru']))->assertRedirect();
        $this->assertSame('Baru', $project->fresh()->title);

        $this->post(route('admin.projects.store'), $this->projectData(['category' => 'bukan-kategori']))->assertSessionHasErrors('category');
        $this->post(route('admin.projects.store'), $this->projectData())->assertSessionHasErrors('slug');
        $this->post(route('admin.projects.store'), $this->projectData(['slug' => 'lain', 'image' => '../rahasia.png']))->assertSessionHasErrors('image');
    }

    public function test_admin_changes_reach_the_public_site(): void
    {
        $this->actingAs($this->userWithRole('Staf'));
        $this->post(route('admin.projects.store'), $this->projectData(['title' => 'Portal Publik', 'slug' => 'portal-publik']));
        $this->post(route('admin.achievements.store'), ['year' => 2026, 'title' => 'Juara Satu', 'event' => 'Lomba Nyata', 'organizer' => 'ITS', 'description' => 'Deskripsi']);

        $this->get('/projects')->assertOk()->assertSee('Portal Publik');
        $this->get('/projects/portal-publik')->assertOk()->assertSee('Sorotan')->assertSee('Dua');
        $this->get('/collection')->assertOk()->assertSee('Lomba Nyata');

        $project = Project::where('slug', 'portal-publik')->firstOrFail();
        $this->put(route('admin.projects.update', $project), $this->projectData(['title' => 'Portal Publik', 'slug' => 'portal-publik', 'is_active' => '0']));

        $this->get('/projects')->assertDontSee('Portal Publik');
        $this->get('/projects/portal-publik')->assertNotFound();
    }

    public function test_uploads_are_saved_shown_publicly_and_kept_on_edit(): void
    {
        $this->app->usePublicPath($publicPath = sys_get_temp_dir().'/angelaos-'.uniqid());
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
        $data = ['year' => 2026, 'title' => 'Juara', 'event' => 'Lomba Foto', 'organizer' => 'ITS', 'description' => 'Deskripsi'];
        $this->actingAs($this->userWithRole('Staf'));

        $this->post(route('admin.achievements.store'), $data + [
            'image' => UploadedFile::fake()->createWithContent('foto prestasi saya.png', $png),
            'document' => UploadedFile::fake()->createWithContent('sertifikat.pdf', "%PDF-1.4\n%%EOF\n"),
        ])->assertSessionHasNoErrors()->assertRedirect(route('admin.achievements.index'));

        $achievement = Achievement::where('event', 'Lomba Foto')->firstOrFail();
        $this->assertMatchesRegularExpression('/^[0-9a-f-]{36}\.png$/', $achievement->image);
        $this->assertFileExists("{$publicPath}/images/achievements/{$achievement->image}");
        $this->assertFileExists("{$publicPath}/documents/{$achievement->document}");
        $this->get('/collection')->assertSee($achievement->image)->assertSee($achievement->document);

        $image = $achievement->image;
        $this->put(route('admin.achievements.update', $achievement), ['title' => 'Juara Baru'] + $data)->assertSessionHasNoErrors();
        $this->assertSame($image, $achievement->fresh()->image);

        // A real UploadedFile, because fake files report their MIME type from the filename.
        $script = tempnam(sys_get_temp_dir(), 'upl');
        file_put_contents($script, '<?php echo 1;');
        $this->post(route('admin.achievements.store'), $data + ['image' => new UploadedFile($script, 'jahat.png', null, null, true)])
            ->assertSessionHasErrors('image');
        $this->post(route('admin.achievements.store'), $data + ['document' => new UploadedFile($script, 'jahat.pdf', null, null, true)])
            ->assertSessionHasErrors('document');
    }

    public function test_active_projects_are_listed_before_archived_ones(): void
    {
        Project::factory()->create(['title' => 'Proyek Aktif Lama', 'is_active' => true]);
        Project::factory()->create(['title' => 'Proyek Arsip Baru', 'is_active' => false]);

        $this->actingAs($this->userWithRole('Admin'))->get('/admin/projects')
            ->assertSeeInOrder(['Proyek Aktif Lama', 'Proyek Arsip Baru']);
    }

    public function test_project_slug_is_generated_and_normalized(): void
    {
        $this->actingAs($this->userWithRole('Staf'));

        $this->post(route('admin.projects.store'), $this->projectData(['title' => 'Portal Saya Baru', 'slug' => '']))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', ['slug' => 'portal-saya-baru']);

        $this->post(route('admin.projects.store'), $this->projectData(['slug' => 'pakai spasi']))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', ['slug' => 'pakai-spasi']);

        $this->post(route('admin.projects.store'), $this->projectData(['slug' => ['x']]))->assertSessionHasErrors('slug');
    }

    public function test_search_filters_and_pagination_keep_the_query_string(): void
    {
        Project::factory()->count(12)->create(['title' => 'Portal Cari', 'role' => 'Dev', 'is_active' => false, 'category' => Project::CATEGORIES[0]]);
        Project::factory()->create(['title' => 'Portal Cari Aktif', 'role' => 'Dev', 'is_active' => true, 'category' => Project::CATEGORIES[0]]);
        Project::factory()->create(['title' => 'Lainnya', 'role' => 'Designer', 'is_active' => false, 'category' => Project::CATEGORIES[1]]);
        $this->achievement(['event' => 'Lomba Lama', 'year' => 2023]);
        $this->achievement(['event' => 'Lomba Baru', 'year' => 2026]);
        $this->actingAs($this->userWithRole('Admin'));

        $this->get('/admin/projects?q=Cari&status=0')->assertOk()
            ->assertSee('Portal Cari')->assertDontSee('Portal Cari Aktif')->assertDontSee('Lainnya')
            ->assertSee('q=Cari&amp;status=0&amp;page=2', false);
        $this->get('/admin/projects?q=Designer')->assertSee('Lainnya')->assertDontSee('Portal Cari');
        $this->get('/admin/projects?category='.urlencode(Project::CATEGORIES[1]))->assertSee('Lainnya')->assertDontSee('Portal Cari');
        $this->get('/admin/projects?q[]=x')->assertSessionHasErrors('q');
        $this->get('/admin/achievements?year=2023')->assertSee('Lomba Lama')->assertDontSee('Lomba Baru');
        $this->get('/admin/achievements?q=Baru')->assertSee('Lomba Baru')->assertDontSee('Lomba Lama');
    }

    public function test_demo_login_only_works_locally(): void
    {
        $user = $this->userWithRole('Admin');
        $user->update(['email' => 'admin@angelaos.test']);

        $this->post('/demo-login/admin')->assertNotFound();
        $this->assertGuest();
        $this->get('/login')->assertDontSee('Login sebagai Admin');

        // Laravel only skips CSRF automatically in the "testing" environment.
        $this->withoutMiddleware(ValidateCsrfToken::class);
        $this->app['env'] = 'local';
        $this->get('/login')->assertSee('Login sebagai Admin');
        $this->post('/demo-login/admin')->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }
}
