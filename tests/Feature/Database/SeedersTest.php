<?php

namespace Tests\Feature\Database;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedersTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_seeder_creates_admin()
    {
        $this->seed(\Database\Seeders\UserSeeder::class);

        $admin = User::where('email', 'admin@institutoulyssesguimaraes.com.br')->first();
        $this->assertNotNull($admin);
        $this->assertEquals('Administrador', $admin->name);
        $this->assertEquals(1, (int)$admin->active);
    }

    public function test_database_seeder_runs()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->assertGreaterThanOrEqual(1, User::count());
    }

    public function test_admin_user_password_hashed()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $admin = User::where('email', 'admin@institutoulyssesguimaraes.com.br')->first();
        $this->assertTrue(password_verify('Iug@2026Adm!', $admin->password));
    }
}
