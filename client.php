<?php
require 'WebhookProxy.php';

$data = WebhookProxy\client($_GET['developer']);

echo $data;
