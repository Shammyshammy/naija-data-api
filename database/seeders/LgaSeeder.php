<?php

namespace Database\Seeders;

use App\Models\Lga;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LgaSeeder extends Seeder
{
    public function run(): void
    {
        // Sample LGAs — 5 per state for demo. Complete list is 774.
        $data = [
            'ABI' => ['Aba North', 'Aba South', 'Arochukwu', 'Bende', 'Ikwuano'],
            'ADA' => ['Demsa', 'Fufore', 'Ganye', 'Girei', 'Gombi'],
            'AKW' => ['Abak', 'Eastern Obolo', 'Eket', 'Esit Eket', 'Essien Udim'],
            'ANA' => ['Aguata', 'Anambra East', 'Anambra West', 'Anaocha', 'Awka North'],
            'BAU' => ['Alkaleri', 'Bauchi', 'Bogoro', 'Damban', 'Darazo'],
            'BAY' => ['Brass', 'Ekeremor', 'Kolokuma/Opokuma', 'Nembe', 'Ogbia'],
            'BEN' => ['Ado', 'Agatu', 'Apa', 'Buruku', 'Gboko'],
            'BOR' => ['Abadam', 'Askira/Uba', 'Bama', 'Bayo', 'Biu'],
            'CRO' => ['Abi', 'Akamkpa', 'Akpabuyo', 'Bakassi', 'Bekwarra'],
            'DEL' => ['Aniocha North', 'Aniocha South', 'Bomadi', 'Burutu', 'Ethiope East'],
            'EBO' => ['Abakaliki', 'Afikpo North', 'Afikpo South', 'Ebonyi', 'Ezza North'],
            'EDO' => ['Akoko-Edo', 'Egor', 'Esan Central', 'Esan North-East', 'Esan South-East'],
            'EKI' => ['Ado Ekiti', 'Efon', 'Ekiti East', 'Ekiti South-West', 'Ekiti West'],
            'ENU' => ['Aninri', 'Awgu', 'Enugu East', 'Enugu North', 'Enugu South'],
            'GOM' => ['Akko', 'Balanga', 'Billiri', 'Dukku', 'Funakaye'],
            'IMO' => ['Aboh Mbaise', 'Ahiazu Mbaise', 'Ehime Mbano', 'Ezinihitte', 'Ideato North'],
            'JIG' => ['Auyo', 'Babura', 'Biriniwa', 'Birnin Kudu', 'Buji'],
            'KAD' => ['Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara'],
            'KAN' => ['Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi'],
            'KAT' => ['Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa'],
            'KEB' => ['Aleiro', 'Arewa Dandi', 'Argungu', 'Augie', 'Bagudo'],
            'KOG' => ['Adavi', 'Ajaokuta', 'Ankpa', 'Bassa', 'Dekina'],
            'KWA' => ['Asa', 'Baruten', 'Edu', 'Ekiti', 'Ifelodun'],
            'LAG' => ['Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa'],
            'NAS' => ['Akwanga', 'Awe', 'Doma', 'Karu', 'Keana'],
            'NIG' => ['Agaie', 'Agwara', 'Bida', 'Borgu', 'Bosso'],
            'OGU' => ['Abeokuta North', 'Abeokuta South', 'Ado-Odo/Ota', 'Egbado North', 'Egbado South'],
            'OND' => ['Akoko North-East', 'Akoko North-West', 'Akoko South-East', 'Akoko South-West', 'Akure North'],
            'OSU' => ['Aiyedaade', 'Aiyedire', 'Atakunmosa East', 'Atakunmosa West', 'Boluwaduro'],
            'OYO' => ['Afijio', 'Akinyele', 'Atiba', 'Atisbo', 'Egbeda'],
            'PLA' => ['Barkin Ladi', 'Bassa', 'Bokkos', 'Jos East', 'Jos North'],
            'RIV' => ['Abua/Odual', 'Ahoada East', 'Ahoada West', 'Akuku-Toru', 'Andoni'],
            'SOK' => ['Binji', 'Bodinga', 'Dange Shuni', 'Gada', 'Goronyo'],
            'TAR' => ['Ardo Kola', 'Bali', 'Donga', 'Gashaka', 'Gassol'],
            'YOB' => ['Bade', 'Bursari', 'Damaturu', 'Fika', 'Fune'],
            'ZAM' => ['Anka', 'Bakura', 'Birnin Magaji', 'Bukkuyum', 'Bungudu'],
            'FCT' => ['Abaji', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali'],
        ];

        foreach ($data as $stateCode => $lgaNames) {
    $state = State::where('code', $stateCode)->first();
    if (! $state) continue;

    foreach ($lgaNames as $name) {
        Lga::updateOrCreate(
            ['state_id' => $state->id, 'name' => $name],
            ['slug' => Str::slug($name)]
        );
    }
}
    }
}