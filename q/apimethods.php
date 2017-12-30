<?php

function getHashrate() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:20421/getinfo');
    $result = curl_exec($ch);
    $obj = json_decode($result, TRUE);
    curl_close($ch);
    //print_r($obj);
    $difficulty = $obj['difficulty'];
    $hashrate = round($difficulty / 240);
    return $hashrate;
}

function getHeight() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:20421/getinfo');
    $result = curl_exec($ch);
    $obj = json_decode($result, TRUE);
    curl_close($ch);
    return $obj['last_known_block_index'];
}

function getReward($formatted = true) {
    $data_string = '{"jsonrpc":"2.0","id":"test","method":"getlastblockheader","params":" "}';
    $ch = curl_init('http://127.0.0.1:20421/json_rpc');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($ch);
    $responseData = json_decode($result, TRUE);
    $rewardRaw = $responseData['result']['block_header']['reward'];
    if ($formatted) {
        $reward  = number_format($rewardRaw / 1000000000000, 12, ".", "");
    }
    else {
        $reward  = number_format($rewardRaw, 12, ".", "");
    }
    curl_close($ch);
    return $reward;
}

function getSupply($formatted = true) {
    include_once(dirname(__DIR__).'/q/util.php');

    $data_string = '{"jsonrpc":"2.0","id":"test","method":"getlastblockheader","params":" "}';
    
    $ch = curl_init('http://127.0.0.1:20421/json_rpc');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    
    $result = curl_exec($ch);
    
    // print_r($result);
    
    // Decode the response
    $responseData = json_decode($result, TRUE);
    
    // Print the date from the response
    // echo(json_encode($responseData, JSON_PRETTY_PRINT));
    
    $reward = $responseData['result']['block_header']['reward'];
    
    //print_r($hash);
    curl_close($ch);
    
    $supply = calculateSupply($reward);
    
    if ($formatted) {
        $supply  = number_format($supply / 1000000000000, 12, ".", "");
    }
    else {
        $supply  = number_format($supply, 12, ".", "");
    }
    return $supply;
}

function getLastBlockHeader() {
    $data_string = '{"jsonrpc":"2.0","id":"test","method":"getlastblockheader","params":" "}';
    
    $ch = curl_init('http://127.0.0.1:20421/json_rpc');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    
    $result = curl_exec($ch);
    
    // Decode the response
    $responseData = json_decode($result, TRUE);
    
    curl_close($ch);

    return $responseData;
}

?>