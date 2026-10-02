<?php
// tests/php/news-functions-test.php
// Run with: php tests/php/news-functions-test.php

// Provide the two pure functions via a guard so the WP-dependent ones are skipped.
define('NEWS_FUNCTIONS_TEST', true);
require __DIR__ . '/../../includes/news-functions.php';

$failures = 0;
function check($cond, $msg) { global $failures; if (!$cond) { $failures++; echo "FAIL: $msg\n"; } else { echo "ok: $msg\n"; } }

check(news_topic_badge_color('trailer')   === '#7c3aed', 'trailer color');
check(news_topic_badge_color('streaming') === '#0e7490', 'streaming color');
check(news_topic_badge_color('premiera')  === '#b91c1c', 'premiera color');
check(news_topic_badge_color('editorial') === '#a16207', 'editorial color');
check(news_topic_badge_color('unknown')   === '#003a61', 'fallback color');

check(news_parse_related_ids('1886,12387,1402') === [1886,12387,1402], 'basic parse');
check(news_parse_related_ids(' 1886 , 0 , 12387 , 12387 ') === [1886,12387], 'trims, drops zero, dedupes');
check(news_parse_related_ids('') === [], 'empty string');
check(news_parse_related_ids('[1886,12387]') === [1886,12387], 'tolerates stray brackets');
check(news_parse_related_ids('abc, 12 , <x> , 0 , 34') === [12,34], 'drops non-numeric/zero parts');

echo $failures === 0 ? "\nALL PASS\n" : "\n$failures FAILURES\n";
exit($failures === 0 ? 0 : 1);
