<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admins
        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'role' => 'admin',
        ]);

        // Create 10 Students
        $students = \App\Models\User::factory()->count(10)->create([
            'role' => 'student',
        ]);

        // Create Events
        $w1 = \App\Models\Event::create([
            'title' => 'Mastering Laravel & Livewire',
            'speaker' => 'Taylor Otwell',
            'location' => 'Main Hall A',
            'total_seats' => 20,
        ]);

        $w2 = \App\Models\Event::create([
            'title' => 'Vue.js for Modern Frontends',
            'speaker' => 'Evan You',
            'location' => 'Room 302',
            'total_seats' => 5,
        ]);

        $w3 = \App\Models\Event::create([
            'title' => 'Database Optimization Strategies',
            'speaker' => 'Aaron Francis',
            'location' => 'Lab B',
            'total_seats' => 15,
        ]);

        // Register students to event 1 (10 students)
        foreach ($students as $student) {
            \App\Models\Registration::create([
                'user_id' => $student->id,
                'event_id' => $w1->id,
            ]);
        }

        // Register 5 students to event 2 (which fills it up completely to test the "Closed" button)
        $w2Students = $students->take(5);
        foreach ($w2Students as $student) {
            \App\Models\Registration::create([
                'user_id' => $student->id,
                'event_id' => $w2->id,
            ]);
        }
    }
}
