<?php
require 'WebhookProxy.php';

define('SERVER_URL', 'https://dev-1.nibot.net/client.php');
define('LOCAL_URL', 'http://localhost:3000/hello/telegram.php');
define('DEVELOPER', 'nicklasos');

$data = WebhookProxy\receive(SERVER_URL, $_GET['developer'] ?? DEVELOPER, isset($_GET['clear']));

foreach ($data as $item) {
    WebhookProxy\call($item);
}
