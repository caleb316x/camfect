<?php
include "./curlLib.php";

$currentpost = 2000017;
$hash = "";
$delay = 3600/2;

function login()
{
    $response = botcurl::curldata_with_cookie(
        "https://www.camfect.com/requests.php?f=login",
        "username=caleb&password=caleb316",
        array(
            "Accept: */*",
            "X-Requested-With: XMLHttpRequest",
            "Accept-Language: en-US,en;q=0.9",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36",
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            "Sec-GPC: 1",
            "Origin: https://www.camfect.com",
            "Sec-Fetch-Site: same-origin",
            "Sec-Fetch-Mode: cors",
            "Sec-Fetch-Dest: empty",
            "Referer: https://www.camfect.com/CatsOnly",
        )
    );

    // echo $response;

    $jsondata = json_decode($response, true);

    if (isset($jsondata["error"]) || isset($jsondata["errors"])) {
        echo botcurl::colortext("Sign-in Failed\n");
        login();
    } else {
        echo botcurl::colortext("Sign-in Success\n");
        // bot();
        gethash();
    }
}

function gethash()
{
    global $hash;
    $response = botcurl::curldata_get_with_cookie(
        "https://www.camfect.com/DailyQuote"
    );

    $dom = new DOMDocument();
    @$dom->loadHTML($response);
    $xp = new DOMXpath($dom);
    $nodes = $xp->query('//input[@name="hash_id"]');
    $node = $nodes->item(0);

    $n = $node->getAttribute('value');

    $hash = $n;
    bot();
}


function bot()
{
    global $hash,$delay;
    $response = botcurl::curldata_with_cookie(
        "https://www.camfect.com/requests.php?f=posts&s=insert_new_post",
        "postText=" . quote() . "&album_name=&video_thumb=&feeling=&feeling_type=&filename=&answer%5B%5D=&answer%5B%5D=&postMap=&musiccount=&post_color=&postPhotos%5B%5D=&postVideo=&postFile=&postMusic=&group_id=13&hash_id=$hash&postRecord=&postSticker=",
        array(
            "Accept: */*",
            "X-Requested-With: XMLHttpRequest",
            "Accept-Language: en-US,en;q=0.9",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36",
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            "Sec-GPC: 1",
            "Origin: https://www.camfect.com",
            "Sec-Fetch-Site: same-origin",
            "Sec-Fetch-Mode: cors",
            "Sec-Fetch-Dest: empty",
            "Referer: https://www.camfect.com/CatsOnly"
        )
    );

    $res = json_decode($response, true);
    if(isset($res['status'])){
        if($res['status'] == 200){
            echo "+100 points\n";
            echo botcurl::colortext("Done\n");
            sleep(5);
            bot();
        }
        else{
            echo botcurl::colortext("Reached limit\n", "red");
            echo "please wait (".($delay/60)." minutes)\n";
            sleep($delay);
            bot();
        }
    }
    else{
        print_r($res);
    }

}

function like()
{
    global $currentpost;
    echo "POST ID: $currentpost\n";
    $response = botcurl::curldata(
        "https://www.camfect.com/requests.php?hash=adac014a4b225ab50348&f=posts&s=register_reaction&post_id=$currentpost&reaction=1&_=1610979936576",
        // "postText=meow2&album_name=&video_thumb=&feeling=&feeling_type=&filename=&answer%5B%5D=&answer%5B%5D=&postMap=&musiccount=&post_color=&postPhotos%5B%5D=&postVideo=&postFile=&postMusic=&group_id=13&hash_id=72e36f20253764e6ba59551938fff557f9f6ce4d&postRecord=&postSticker=",
        "",
        array(
            "Accept: */*",
            "X-Requested-With: XMLHttpRequest",
            "Accept-Language: en-US,en;q=0.9",
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36",
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
            "Sec-GPC: 1",
            "Origin: https://www.camfect.com",
            "Sec-Fetch-Site: same-origin",
            "Sec-Fetch-Mode: cors",
            "Sec-Fetch-Dest: empty",
            "Referer: https://www.camfect.com/CatsOnly",
            // "Accept-Encoding: gzip, deflate, br",
            "Cookie: PHPSESSID=804f56fa0c229ac3f11fcafa0c2cfebe; ad-con=%7B%26quot%3Bdate%26quot%3B%3A%26quot%3B2021-01-18%26quot%3B%2C%26quot%3Bads%26quot%3B%3A%5B%5D%7D; access=1; src=1; cookieconsent_status=dismiss; user_id=ef884f65514e421f3da4825d83439551c004b8c1d4ac8bfd20ca583804c5f0ed34339faa814372628d4112ce0aabe7aeef422c136a222624; day_status=1; last_sidebar_update=1610968137; mode=night; post_privacy=2; memory=1; _us=1611063337"
        ),
        "GET"
    );

    echo botcurl::colortext("Done\n");
    $currentpost++;
    sleep(3);
    like();
}


function quote()
{
    global $q, $a;

    $response = botcurl::curldata_get("https://api.quotable.io/random");;

    $res = json_decode($response, true);
    if(!empty($res["content"])){
        $q = '"' . $res["content"] . '"' . "\n\n- " . $res['author'];
        // $a = "- ".$res['author'];
        echo date("h:i:s a") . "\n";
        echo "qoute generated!\n";
        // echo "$q\n";
        return $q;
    }
    else{
        sleep(3);
        quote();
    }
}

login();
// bot();
// like();