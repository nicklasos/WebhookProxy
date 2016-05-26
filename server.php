<?php
require 'WebhookProxy.php';

WebhookProxy\server(
    $_GET['developer'],
    $_GET['url'],
    file_get_contents("php://input")
);
