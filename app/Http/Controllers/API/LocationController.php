<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function provinces(Request $request)
    {
        return Province::all();
    }

    public function cities(Request $request, $provinces_id)
    {
        return City::where('province_id', $provinces_id)->get();
    }

    public function getOngkir(Request $request) {

        $origin = 455; // Origin kota Tangerang
        $destination = $request['destination'];
        $weight = 1700; // Karena produknya ga punya berat, maka default 1700
        $courier = $request['courier']; 
        
        $response = Http::asForm()->withHeaders([
            'key' => '8b8005a44af28b7fb7c244ea400f0514'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier

        ]);
        
        return $response['rajaongkir']['results'][0]['costs'];
    }

    // capek sendiri
    //emg pakar masalahnya apa? yakek biasanya, mempersulit diri sendiri

    //typo? wkwkwkwkw
    // sebelumnya, lu manggil facedes App. Buat apa?
    //ga manggil itu otomatis, lalu? didiemin aja iyaa....
}
