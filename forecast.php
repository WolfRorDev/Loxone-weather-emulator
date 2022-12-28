<?php 
// Xxample of get request from loxone Miniserver for forecast:
// http://weather.loxone.com:6066/forecast/?user=loxone_00000000000&coord=00.0000,01.0000&asl=83&format=1&new_api=1
// 00000000000 - serial number of Loxone Miniserver
// 00.0000 - longitude
// 01.0000 - latitude
$city = ""; //Your city
$country = ""; //Your Country
$utc = "UTC+00.00"; //Your timezone
date_default_timezone_set(''); //Set timezone using values from https://www.php.net/manual/en/timezones.php
$userKey = "00000000000000000000000000000000"; //Your key from https://openweathermap.org/
$coord = explode(",", $_GET['coord']);

$Day = [
    1 => 'Mon',
    2 => 'Tue',
    3 => 'Wed',
    4 => 'Thu',
    5 => 'Fri',
    6 => 'Sat',
    0 => 'Sun'
];
$ImgCode = [
    'clear'=> 1,
    'sunny'=> 1,
    'mostly sunny'=> 2,
    'partly cloudy'=> 10,
    'partly sunny'=> 17,
    'mostly cloudy'=> 20,
    'cloudy'=> 22,
    'clouds'=> 22,
    'overcast'=> 22,
    'mist'=> 17,
    'fog'=> 17,
    'chance of showers'=> 31,
    'showers'=> 33,
    'chance of rain'=> 31,
    'rain'=> 23,
    'thunderstorms'=> 28,
    'sleet'=> 35,
    'chance of snow'=> 32,
    'snow'=> 24
];
$dt = 0;
$URL = "https://api.openweathermap.org/data/3.0/onecall?appid=$userKey&lat=$coord[1]&lon=$coord[0]&units=metric&exclude=minutely,daily";
$URL2 = "https://api.openweathermap.org/data/2.5/forecast?appid=$userKey&lat=$coord[1]&lon=$coord[0]&units=metric";
$xml = json_decode(str_replace("1h","v1h",file_get_contents($URL)));

echo "<mb_metadata>
id;name;longitude;latitude;height (m.asl.);country;timezone;utc-timedifference;sunrise;sunset;local date;weekday;local time;temperature(C);feeledTemperature(C);windspeed(km/h);winddirection(degr);wind gust(km/h);low clouds(%);medium clouds(%);high clouds(%);precipitation(mm);probability of Precip(%);snowFraction;sea level pressure(hPa);relative humidity(%);CAPE;picto-code;radiation (W/m2);
</mb_metadata><valid_until>2030-12-31</valid_until>
<station>
;$city;$coord[0];$coord[1];-9999;$country;CEST;$utc;".date('H:i', $xml->current->sunrise).";".date('H:i', $xml->current->sunset).";".PHP_EOL;

foreach ($xml->hourly as $hour) {
    $rain = -9999;
    $wind_gust = -9999;
    if (isset($hour->wind_gust))
    {
        $wind_gust = $hour->wind_gust;
    }
    if (isset($hour->rain))
    {
        $rain = $hour->rain->v1h;
    }
    elseif(isset($hour->snow))
    {
        $rain = $hour->snow->v1h;
    }
    echo date('d.m.Y', $hour->dt).";".$Day[date('w', $hour->dt)].";".date('H', $hour->dt).";"
        .$hour->temp.";".$hour->feels_like.";".$hour->wind_speed.";".$hour->wind_deg.";".$wind_gust.";"
        .$hour->clouds.";"
        .$hour->clouds.";"
        .$hour->clouds.";"
        .$rain.";"
        .$hour->pop.";"."0;"
        .$hour->pressure.";".$hour->humidity.";-9999;"
        .$ImgCode[strtolower($hour->weather[0]->main)]
        .";-9999;".PHP_EOL;
}

$dt = $xml->hourly[count($xml->hourly)-1]->dt;
$xml2 = json_decode(str_replace('3h', 'a3h',file_get_contents($URL2)));

foreach ($xml2->list as $hour) {
    if($dt < $hour->dt)
    {
        $rain = -9999;
        $wind_gust = -9999;
        if (isset($hour->wind_gust))
        {
            $wind_gust = $hour->wind_gust;
        }
        if (isset($hour->rain->a3h))
        {
            $rain = $hour->rain->a3h;
        }
        elseif(isset($hour->snow->a3h))
        {
            $rain = $hour->snow->a3h;
        }
        echo date('d.m.Y', $hour->dt).";".$Day[date('w', $hour->dt)].";".date('H', $hour->dt).";"
            .$hour->main->temp.";".$hour->main->feels_like.";".$hour->wind->speed.";".$hour->wind->deg.";".$hour->wind->gust.";"
            .$hour->clouds->all.";".$hour->clouds->all.";".$hour->clouds->all.";".$rain.";".$hour->pop.";"."0;"
            .$hour->main->grnd_level.";".$hour->main->humidity.";-9999;".$ImgCode[strtolower($hour->weather[0]->main)].";-9999;".PHP_EOL;    
    }
}

echo "</station>";
?>