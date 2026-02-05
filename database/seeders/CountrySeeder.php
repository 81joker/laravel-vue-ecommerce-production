<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bundesLänder = [
            "BG" => "Burgenland",
            "K" => "Kärnten",
            "NÖ" => "Niederösterreich",
            "OÖ" => "Oberösterreich",
            "S" => "Salzburg",
            "ST" => "Steiermark",
            "T" => "Tirol",
            "V" => "Vorarlberg",
            "W" => "Wien"
        ];
        $usaStates = [
            "AL" => 'Alabama',
            "AK" => 'Alaska',
            "AZ" => 'Arizona',
            "AR" => 'Arkansas',
            "CA" => 'California',
        ];
        $countries = [
            ['code' => 'geo', 'name' => 'Georgia', 'states' => null],
            ['code' => 'ind', 'name' => 'India', 'states' => null],
            ['code' => 'usa', 'name' => 'United States of America', 'states' => json_encode($usaStates)],
            ['code' => 'au', 'name' => 'Austria', 'states' => json_encode($bundesLänder)],
            ['code' => 'ger', 'name' => 'Germany', 'states' => null],
        ];
        Country::insert($countries);

    }
}

// {
//     "BG": "Burgenland",
//     "K": "Kärnten",
//     "NÖ": "Niederösterreich",
//     "OÖ": "Oberösterreich",
//     "S": "Salzburg",
//     "ST": "Steiermark",
//     "T": "Tirol",
//     "V": "Vorarlberg",
//     "W": "Wien"
//   }

// {"AK": "Alaska", "AL": "Alabama", "AR": "Arkansas", "AZ": "Arizona", "CA": "California"}