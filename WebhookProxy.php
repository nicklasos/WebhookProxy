<?php
namespace WebhookProxy;

function server(string $developer, string $url, string $body)
{
    $json = json_encode([
        'developer' => $developer,
        'url' => $url,
        'body' => base64_encode($body),
    ]);

    file_put_contents("logs/$developer.log", $json . "\n", FILE_APPEND);
}

function client(string $developer): string
{
    $file = "logs/$developer.log";
    $data = file_get_contents($file);
    file_put_contents($file, '');

    return $data;
}

function receive(string $url, string $developer): array
{
    $result = [];

    $data = file_get_contents("$url?developer=$developer");
    foreach (explode("\n", rtrim($data)) as $json) {
        $row = json_decode($json, true);
        $row['body'] = base64_decode($row['body']);

        $result[] = $row;
    }

    return $result;
}
