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

function client(string $developer, bool $clear): string
{
    $file = "logs/$developer.log";
    $data = file_get_contents($file);
    
    if ($clear) {
        file_put_contents($file, '');
    }

    return $data;
}

function receive(string $url, string $developer, bool $clear): array
{
    $result = [];
    $url = "$url?developer=$developer";
    
    if ($clear) {
        $url .= '&clear';
    }

    $data = file_get_contents($url);
    foreach (explode("\n", rtrim($data)) as $json) {
        if ($json) {
            $row = json_decode($json, true);
            $row['body'] = base64_decode($row['body']);

            $result[] = $row;
        }
    }

    return $result;
}

function call(array $item)
{
    $curl = curl_init(url($item['url']));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $item['body']);
    $response = curl_exec($curl);

    echo $response;
}

function url(string $url): string
{
    $url = LOCAL_URL . $url;

    if ($_GET) {
        if (parse_url($url)['query'] ?? false) {
            $url .= '&';
        } else {
            $url .= '?';
        }

        $url .= http_build_query($_GET);
    }

    return $url;
}
