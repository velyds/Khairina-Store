<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Seeder;

use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'key' => '8b8005a44af28b7fb7c244ea400f0514'
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces =  $response['rajaongkir']['results'];

        foreach($provinces as $province) {
            $data_province[] = [
                'id' => $province['province_id'],
                'province' => $province['province']
            ];
        }

        Province::insert($data_province);
    }
}
