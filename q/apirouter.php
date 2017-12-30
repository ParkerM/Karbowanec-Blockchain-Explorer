<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['path'])) {
        echo "Missing path parameter"; die();
    }
    if ($_GET['path'] == 'lastblock') {
        $data = getLastBlock();
    }
    else
    {
        $path = $_GET['path'];
        $data = getJson($path);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $data = postJsonRpc($obj);
} else { 
    http_response_code(405); die(); 
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($data);

function getLastBlock() {
    require_once('apimethods.php');
    $obj = getLastBlockHeader();

    //rename 'block_header' key to 'block'
    $obj['result']['block'] = $obj['result']['block_header'];
    unset($obj['result']['block_header']);

    $obj['result']['block']['alreadyGeneratedCoins'] = getSupply(false);
    $obj['result']['block']['baseReward'] = getReward(false);
    return $obj;
}

function getJson($path) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:20421/$path");
    $result = curl_exec($ch);
    $response = json_decode($result, true);
    curl_close($ch);

    return $response;
}

function postJsonRpc($obj) {
    $data_string = filterMissingMethods($obj);
    $ch = curl_init("http://127.0.0.1:20421/json_rpc");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($ch);
    $response = json_decode($result, true);
    curl_close($ch);

    return $response;
}

function filterMissingMethods($obj) {
    if (!isset($obj['method'])) return json_encode($obj);
    
    if ($obj['method'] == 'f_block_json') {
        $obj['method'] = 'getblockheaderbyhash';
    }
    elseif ($obj['method'] == 'f_blocks_list_json') {
            $obj['method'] == 'getblockheaderbyheight';
    }
    return json_encode($obj);
}

?>