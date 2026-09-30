<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HolidaySeeder extends Seeder
{
    public function run(): void
    {
        $holidays = [
            // 2026
            [2026, '01-01', "New Year's Day",                'public',    'First day of the year'],
            [2026, '03-20', 'Eid al-Fitr',                   'religious', 'End of Ramadan (approx.)'],
            [2026, '03-21', 'Eid al-Fitr Holiday',           'religious', 'Second day of Eid al-Fitr'],
            [2026, '04-03', 'Good Friday',                   'religious', 'Christian observance'],
            [2026, '04-06', 'Easter Monday',                 'religious', 'Christian observance'],
            [2026, '05-01', 'Workers\' Day',                 'public',    'International Labour Day'],
            [2026, '05-27', 'Eid al-Adha',                   'religious', 'Feast of Sacrifice (approx.)'],
            [2026, '05-28', 'Eid al-Adha Holiday',           'religious', 'Second day of Eid al-Adha'],
            [2026, '06-12', 'Democracy Day',                 'public',    'Return to democratic rule'],
            [2026, '06-16', 'Eid al-Maulud',                 'religious', 'Prophet Muhammad\'s birthday (approx.)'],
            [2026, '10-01', 'Independence Day',              'public',    'Nigerian Independence'],
            [2026, '12-25', 'Christmas Day',                 'religious', 'Christian observance'],
            [2026, '12-26', 'Boxing Day',                    'religious', 'Day after Christmas'],
            // 2027
            [2027, '01-01', "New Year's Day",                'public',    'First day of the year'],
            [2027, '03-10', 'Eid al-Fitr',                   'religious', 'End of Ramadan (approx.)'],
            [2027, '03-11', 'Eid al-Fitr Holiday',           'religious', 'Second day of Eid al-Fitr'],
            [2027, '03-26', 'Good Friday',                   'religious', 'Christian observance'],
            [2027, '03-29', 'Easter Monday',                 'religious', 'Christian observance'],
            [2027, '05-01', 'Workers\' Day',                 'public',    'International Labour Day'],
            [2027, '05-17', 'Eid al-Adha',                   'religious', 'Feast of Sacrifice (approx.)'],
            [2027, '05-18', 'Eid al-Adha Holiday',           'religious', 'Second day of Eid al-Adha'],
            [2027, '06-12', 'Democracy Day',                 'public',    'Return to democratic rule'],
            [2027, '06-05', 'Eid al-Maulud',                 'religious', 'Prophet Muhammad\'s birthday (approx.)'],
            [2027, '10-01', 'Independence Day',              'public',    'Nigerian Independence'],
            [2027, '12-25', 'Christmas Day',                 'religious', 'Christian observance'],
            [2027, '12-26', 'Boxing Day',                    'religious', 'Day after Christmas'],
        ];

        foreach ($holidays as $h) {
            Holiday::create([
                'year'        => $h[0],
                'date'        => $h[0] . '-' . $h[1],
                'name'        => $h[2],
                'type'        => $h[3],
                'description' => $h[4],
            ]);
        }
    }
}