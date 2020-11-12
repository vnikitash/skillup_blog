<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WeatherController
{
    const KALVIN = 273.15;

    public function index(Request $request)
    {
        $city = $request->city ?? 'Kiev';

        $apiKey = config('weather.key');

        $json = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey");

        $array = json_decode($json, true);

        $country = $array['sys']['country'];
        $city = $array['name'];
        $long = $array['coord']['lon'];
        $lat = $array['coord']['lat'];
        $description = $array['weather'][0]['main'];
        $currentTemp = $array['main']['temp'] - self::KALVIN;
        $minT = $array['main']['temp_min'] - self::KALVIN;
        $maxT = $array['main']['temp_max'] - self::KALVIN;
        $humidity = $array['main']['humidity'] . '%';

        die("$city [$country] ($long;$lat); T: $currentTemp (C) [$minT (C) - $maxT (C)] - $description. Humidity: $humidity");
    }

    public function index2(Request $request)
    {

        $city = $request->city ?? 'Kiev';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . config('weather.key'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1'
            ]
        );

        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        $array = json_decode($res, true);

        if ($info['http_code'] === Response::HTTP_OK) {

            $country = $array['sys']['country'];
            $city = $array['name'];
            $long = $array['coord']['lon'];
            $lat = $array['coord']['lat'];
            $description = $array['weather'][0]['main'];
            $currentTemp = $array['main']['temp'] - self::KALVIN;
            $minT = $array['main']['temp_min'] - self::KALVIN;
            $maxT = $array['main']['temp_max'] - self::KALVIN;
            $humidity = $array['main']['humidity'] . '%';

            return response()->json([
                'status' => true,
                'data' => [
                    'country' => $country,
                    'city' => $city,
                    'long' => $long,
                    'lat' => $lat,
                    'currentTemp' => $currentTemp
                ],
            ]);
        }



        return response()->json(['status' => false, 'message' => $array['message'] ?? 'Server error.'], $info['http_code']);
    }

    public function index3(Request $request)
    {
        $city = $request->city ?? 'Kiev';

        $client = new Client();
        $result = $client->post('https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . config('weather.key'));
        dd($result->getBody()->getContents());
    }
}