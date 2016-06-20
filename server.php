<?php
require 'WebhookProxy.php';

WebhookProxy\facebook($_GET);

WebhookProxy\server(
    $_GET['developer'],
    $_GET['url'],
    file_get_contents("php://input")
);
