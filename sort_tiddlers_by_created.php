<?php

// Get datas in an array
$data = json_decode(file_get_contents('data/tiddlers.json'), true);

// Sort ascending by created, if same, by id, and if same, by name (should be enough).
usort($data, function($a, $b) {
    if (!isset($a['created']) || !isset($b['created'])) {
        return 0;
    }
    if ($a['created'] === $b['created']) {
        if ($a['id'] === $b['id']) {
            return ($a['name']) < ($b['name']) ? -1 : 1;
        }
        return ($a['id']) < ($b['id']) ? -1 : 1;
    }
    return ($a['created']) < ($b['created']) ? -1 : 1;
});

// Re-encode in JSON
$data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING | JSON_OBJECT_AS_ARRAY);

// Fix unicode characters that were escaped.
$data = str_replace('\u0026', '&', $data);

file_put_contents('data/tiddlers.json', $data);

