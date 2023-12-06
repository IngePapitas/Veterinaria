<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $e = new Event();
        $e->event = 'Campaña de vacunacion para perros';
        $e->start_date = '2023-12-07 08:00';
        $e->end_date = '2023-12-07 16:00';
        $e->save();

        $e = new Event();
        $e->event = 'Esterilizacion para gatos';
        $e->start_date = '2023-12-13 10:00';
        $e->end_date = '2023-12-13 16:00';
        $e->save();

        $e = new Event();
        $e->event = 'Charla sobre cuidado hacia los animales';
        $e->start_date = '2023-12-15 13:00';
        $e->end_date = '2023-12-15 14:30';
        $e->save();

        $e = new Event();
        $e->event = 'Vacunacion contra la rabia canina';
        $e->start_date = '2023-12-17 08:00';
        $e->end_date = '2023-12-23 19:00';
        $e->save();

        $e = new Event();
        $e->event = 'Campaña de vacunacion para la esterilizacion de gatos y perros';
        $e->start_date = '2024-01-15 08:00';
        $e->end_date = '2024-01-20 16:00';
        $e->save();

    }
}
