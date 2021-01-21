<?php
include "curlLib.php";

function getsat()
{

    botcurl::curldata(
        "url",
        "datahere",
        array()
    );
}


function createwallet()
{
    $response = botcurl::curldata(
        "https://rest-unstable.mainnet.cash/wallet/create",
        '{"type": "seed", "network": "testnet"}',
        array(
            "Content-Type: application/json"
        )
    );


    $jsonfile = fopen("demo.json", "w");

    fwrite($jsonfile, $response);
    fclose($jsonfile);

    echo botcurl::colortext("Wallet Created!\n");
}

function balance($address = "")
{
    $jsonfile = file_get_contents("wallet.json");
    $wallet = json_decode($jsonfile, true);

    $response = botcurl::curldata(
        "https://rest-unstable.mainnet.cash/wallet/balance",
        '{"walletId":"watch:mainnet:bitcoincash:prymjtdf9upfvjtty2m8k20jlay4qc7pdqfn8z0chn"}',
        // '{"walletId":"' . $wallet['walletId'] . '"}',
        array(
            "Content-Type: application/json"
        )
    );

    echo botcurl::colortext("Current Balance: \n");
    print_r($response);
}

function send($amount = 0.01)
{
    echo "amount in usd: ".botcurl::colortext("$$amount\n");

    $jsonfile = file_get_contents("wallet.json");
    $jsonfile2 = file_get_contents("wallet2.json");
    $wallet = json_decode($jsonfile, true);
    $wallet2 = json_decode($jsonfile2, true);

    $response = botcurl::curldata(
        "https://rest-unstable.mainnet.cash/wallet/send",
        '{"walletId": "' . $wallet['walletId'] . '","to": [{"cashaddr": "' . $wallet2['cashaddr'] . '","value": '.$amount.',"unit": "usd"}]}',
        // '{"walletId": "seed:testnet:'.$wallet['seed'].':'.$wallet['derivationPath'].'","to": [{"cashaddr": "' . $wallet2['cashaddr'] . '","value": '.$amount.',"unit": "usd"}]}',
        array(
            "Content-Type: application/json"
        )
    );

    
    echo botcurl::colortext("Sent!\n");

    $res = json_decode($response, true);

    // print_r($res);

    echo "Current Balance: \n";
    echo "bch: ".$res["balance"]["bch"]."\n";
    echo "usd: ".$res["balance"]["usd"]."\n";

    // print_r($response);

}


send();


// balance();
// createwallet();
