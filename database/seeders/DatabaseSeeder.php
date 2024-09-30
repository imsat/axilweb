<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Load module seeders
        $this->moduleSeeder();

         User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@mail.com',
             'role' => 'admin',
         ]);
         User::factory()->create([
             'name' => 'Manager',
             'email' => 'manager@mail.com',
             'role' => 'manager',
         ]);
    }

    public function moduleSeeder()
    {
        // Load module seeders
        $moduleSeeders = [];
        foreach (File::directories(base_path('modules')) as $moduleDirectory) {
            $seederFiles = File::glob($moduleDirectory . '/Database/Seeders/*.php');
            if (!empty($seederFiles)) {
                foreach ($seederFiles as $seederFile) {
                    if (file_exists($seederFile)) {
                        // Extract the class name from the file path
                        $className = 'Modules\\' . basename($moduleDirectory) . '\\' . 'Database\\Seeders\\' . basename($seederFile, '.php');
                        // Check if the class exists before adding it
                        if (class_exists($className)) {
                            $moduleSeeders[] = $className;
                        }
                    }
                }
            }
        }

        if (!empty($moduleSeeders)) {
            $this->call($moduleSeeders);
        }

    }
}
