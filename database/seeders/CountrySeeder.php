<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['code' => 'US', 'name' => 'United States'],
            ['code' => 'CN', 'name' => 'China'],
            ['code' => 'IN', 'name' => 'India'],
            ['code' => 'ID', 'name' => 'Indonesia'],
            ['code' => 'BR', 'name' => 'Brazil'],
            ['code' => 'PK', 'name' => 'Pakistan'],
            ['code' => 'BD', 'name' => 'Bangladesh'],
            ['code' => 'NG', 'name' => 'Nigeria'],
            ['code' => 'RU', 'name' => 'Russia'],
            ['code' => 'MX', 'name' => 'Mexico'],
            ['code' => 'JP', 'name' => 'Japan'],
            ['code' => 'ET', 'name' => 'Ethiopia'],
            ['code' => 'PH', 'name' => 'Philippines'],
            ['code' => 'EG', 'name' => 'Egypt'],
            ['code' => 'VN', 'name' => 'Vietnam'],
            ['code' => 'CD', 'name' => 'DR Congo'],
            ['code' => 'TR', 'name' => 'Turkey'],
            ['code' => 'IR', 'name' => 'Iran'],
            ['code' => 'DE', 'name' => 'Germany'],
            ['code' => 'TH', 'name' => 'Thailand'],
            ['code' => 'GB', 'name' => 'United Kingdom'],
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'IT', 'name' => 'Italy'],
            ['code' => 'ZA', 'name' => 'South Africa'],
            ['code' => 'KR', 'name' => 'South Korea'],
            ['code' => 'ES', 'name' => 'Spain'],
            ['code' => 'AR', 'name' => 'Argentina'],
            ['code' => 'DZ', 'name' => 'Algeria'],
            ['code' => 'CA', 'name' => 'Canada'],
            ['code' => 'AU', 'name' => 'Australia'],
            ['code' => 'SA', 'name' => 'Saudi Arabia'],
            ['code' => 'PE', 'name' => 'Peru'],
            ['code' => 'MA', 'name' => 'Morocco'],
            ['code' => 'CO', 'name' => 'Colombia'],
            ['code' => 'MY', 'name' => 'Malaysia'],
            ['code' => 'CL', 'name' => 'Chile'],
            ['code' => 'NL', 'name' => 'Netherlands'],
            ['code' => 'MW', 'name' => 'Malawi'],
            ['code' => 'KE', 'name' => 'Kenya'],
            ['code' => 'SD', 'name' => 'Sudan'],
            ['code' => 'UZ', 'name' => 'Uzbekistan'],
            ['code' => 'PE', 'name' => 'Peru'],
            ['code' => 'MM', 'name' => 'Myanmar'],
            ['code' => 'UA', 'name' => 'Ukraine'],
            ['code' => 'UG', 'name' => 'Uganda'],
            ['code' => 'GH', 'name' => 'Ghana'],
            ['code' => 'DZ', 'name' => 'Algeria'],
        ];
        DB::table('countries')->insert($countries);
    }
}