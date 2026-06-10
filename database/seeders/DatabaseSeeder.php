<?php

namespace Database\Seeders;

use App\Enums\TeamRole;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\CarroSeeder;
use Database\Seeders\ClienteSeeder;
use Database\Seeders\FuncionarioSeeder;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Ensure an admin user exists with full access (email: admin, password: admin)
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]
        );

        // Ensure admin team exists and assign ownership to admin
        $adminTeam = Team::firstOrCreate([
            'slug' => 'admin'
        ], [
            'name' => 'Admin',
            'is_personal' => false,
        ]);

        // Attach admin as Owner of the admin team
        $adminTeam->members()->syncWithoutDetaching([
            $admin->id => ['role' => TeamRole::Owner->value],
        ]);

        // Set admin's current team
        $admin->current_team_id = $adminTeam->id;
        $admin->save();

        // Seed domain data
        $this->call([
            FuncionarioSeeder::class,
            ClienteSeeder::class,
            CarroSeeder::class,
        ]);
    }
}
