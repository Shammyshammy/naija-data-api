<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            // [name, code, capital, region, lga_count, lat, lng]
            ['Abia',        'ABI', 'Umuahia',     'South East', 17, 5.4527, 7.5248],
            ['Adamawa',     'ADA', 'Yola',         'North East', 21, 9.3265, 12.3984],
            ['Akwa Ibom',   'AKW', 'Uyo',          'South South', 31, 5.0378, 7.9128],
            ['Anambra',     'ANA', 'Awka',         'South East', 21, 6.2109, 7.0740],
            ['Bauchi',      'BAU', 'Bauchi',       'North East', 20, 10.3158, 9.8442],
            ['Bayelsa',     'BAY', 'Yenagoa',      'South South', 8, 4.7719, 6.0699],
            ['Benue',       'BEN', 'Makurdi',      'North Central', 23, 7.3369, 8.7404],
            ['Borno',       'BOR', 'Maiduguri',    'North East', 27, 11.8311, 13.1510],
            ['Cross River', 'CRO', 'Calabar',      'South South', 18, 4.9757, 8.3417],
            ['Delta',       'DEL', 'Asaba',        'South South', 25, 6.1981, 6.7329],
            ['Ebonyi',      'EBO', 'Abakaliki',    'South East', 13, 6.3249, 8.1137],
            ['Edo',         'EDO', 'Benin City',   'South South', 18, 6.3350, 5.6037],
            ['Ekiti',       'EKI', 'Ado-Ekiti',    'South West', 16, 7.6211, 5.2214],
            ['Enugu',       'ENU', 'Enugu',        'South East', 17, 6.4584, 7.5464],
            ['Gombe',       'GOM', 'Gombe',        'North East', 11, 10.2897, 11.1673],
            ['Imo',         'IMO', 'Owerri',       'South East', 27, 5.4836, 7.0332],
            ['Jigawa',      'JIG', 'Dutse',        'North West', 27, 11.7565, 9.3398],
            ['Kaduna',      'KAD', 'Kaduna',       'North West', 23, 10.5222, 7.4383],
            ['Kano',        'KAN', 'Kano',         'North West', 44, 12.0022, 8.5920],
            ['Katsina',     'KAT', 'Katsina',      'North West', 34, 12.9908, 7.6018],
            ['Kebbi',       'KEB', 'Birnin Kebbi', 'North West', 21, 12.4539, 4.1975],
            ['Kogi',        'KOG', 'Lokoja',       'North Central', 21, 7.8023, 6.7333],
            ['Kwara',       'KWA', 'Ilorin',       'North Central', 16, 8.4966, 4.5426],
            ['Lagos',       'LAG', 'Ikeja',        'South West', 20, 6.5244, 3.3792],
            ['Nasarawa',    'NAS', 'Lafia',        'North Central', 13, 8.4939, 8.5157],
            ['Niger',       'NIG', 'Minna',        'North Central', 25, 9.5836, 6.5463],
            ['Ogun',        'OGU', 'Abeokuta',     'South West', 20, 7.1475, 3.3619],
            ['Ondo',        'OND', 'Akure',        'South West', 18, 7.2571, 5.2058],
            ['Osun',        'OSU', 'Osogbo',       'South West', 30, 7.7828, 4.5418],
            ['Oyo',         'OYO', 'Ibadan',       'South West', 33, 7.3775, 3.9470],
            ['Plateau',     'PLA', 'Jos',          'North Central', 17, 9.8965, 8.8583],
            ['Rivers',      'RIV', 'Port Harcourt', 'South South', 23, 4.8156, 7.0498],
            ['Sokoto',      'SOK', 'Sokoto',       'North West', 23, 13.0059, 5.2476],
            ['Taraba',      'TAR', 'Jalingo',      'North East', 16, 8.8929, 11.3772],
            ['Yobe',        'YOB', 'Damaturu',     'North East', 17, 11.7480, 11.9660],
            ['Zamfara',     'ZAM', 'Gusau',        'North West', 14, 12.1628, 6.6610],
            ['Federal Capital Territory', 'FCT', 'Abuja', 'North Central', 6, 9.0765, 7.3986],
        ];

        foreach ($states as $s) {
            State::create([
                'name'      => $s[0],
                'slug'      => Str::slug($s[0]),
                'code'      => $s[1],
                'capital'   => $s[2],
                'region'    => $s[3],
                'lga_count' => $s[4],
                'latitude'  => $s[5],
                'longitude' => $s[6],
            ]);
        }
    }
}