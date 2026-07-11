<?php
function detectLang(string $text): string {
    return preg_match('/\p{Arabic}/u', $text) ? 'ar' : 'en';
}

function translateText(string $text, string $from, string $to): string {
    if (trim($text) === '' || $from === $to) return $text;
    
    $url = 'https://api.mymemory.translated.net/get?' . http_build_query([
        'q'        => $text,
        'langpair' => $from . '|' . $to,
    ]);

    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
    $res = @file_get_contents($url, false, $ctx);
    if (!$res) return $text;

    $data = json_decode($res, true);
    return $data['responseData']['translatedText'] ?? $text;
}
?>