<?php
    date_default_timezone_set('Asia/Manila');


class botcurl
{
    public static function colortext($string, $color = "green")
    {
        //light colors
        $green = "\e[1;32;40m";
        $blue = "\e[1;34m";
        $red = "\e[1;31m";
        $purple = "\e[1;35m";
        $yellow = "\e[1;33m";

        $nc = "\e[0m";
        switch ($color) {
            case "green":
                return "$green$string$nc";
                break;
            case "blue":
                return "$blue$string$nc";
                break;
            case "red":
                return "$red$string$nc";
                break;
            case "purple":
                return "$purple$string$nc";
                break;
            case "yellow":
                return "$yellow$string$nc";
                break;
            default:
                echo $string;
        }
    }

    public static function ipdata()
    {
        $ipdata = file_get_contents("http://ip-api.com/json");

        $jsondata = json_decode($ipdata, true);

        return $jsondata["query"] . " - " . $jsondata["country"] . "\n";
    }

    public static function curldata($url, $postfield, $httpheader, $customrequest = "POST")
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $customrequest,
            CURLOPT_POSTFIELDS => $postfield,
            CURLOPT_HTTPHEADER => $httpheader,
        ));


        $response = curl_exec($curl);

        $res = $response;

        curl_close($curl);

        return $res;
    }

    public static function curldata_with_cookie($url, $postfield, $httpheader, $customrequest = "POST")
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_COOKIEJAR => 'cookie.txt',
            CURLOPT_COOKIEFILE => 'cookie.txt', 
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $customrequest,
            CURLOPT_POSTFIELDS => $postfield,
            CURLOPT_HTTPHEADER => $httpheader,
        ));


        $response = curl_exec($curl);

        $res = $response;

        curl_close($curl);

        return $res;
    }

    public static function curldata_get($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        $res = $response;

        curl_close($curl);

        return $res;
    }

    public static function curldata_get_with_cookie($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_COOKIEJAR => 'cookie.txt',
            CURLOPT_COOKIEFILE => 'cookie.txt', 
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        $res = $response;

        curl_close($curl);

        return $res;
    }
}