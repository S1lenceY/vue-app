<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear primero el usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Luego, ejecutar los otros seeders
        $this->call([
            RolesAndPermissionsSeeder::class,
            SinProgramarExtraSeeder::class,
        ]);
    }
}
