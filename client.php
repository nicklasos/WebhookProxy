<?php
require 'WebhookProxy.php';

$developer = $_GET['developer'] ?? null;
if (!$developer) {
    exit('Set developer parameter');
}

echo WebhookProxy\client($developer, isset($_GET['clean']));
