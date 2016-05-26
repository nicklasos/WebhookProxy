<?php
require 'WebhookProxy.php';

define('SERVER_URL', 'http://localhost:3003/client.php');
define('LOCAL_URL', 'http://localhost:3005/router.php');

$data = WebhookProxy\receive(SERVER_URL, $_GET['developer']);

foreach ($data as $item) {
    call($item);
}

function call(array $item)
{
    $curl = curl_init(LOCAL_URL . $item['url']);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $item['body']);
    $response = curl_exec($curl);

    echo $response;
}
