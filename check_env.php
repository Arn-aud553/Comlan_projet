<?php
$content = file_get_contents('.env');
$lines = explode("\n", $content);
foreach ($lines as $line) {
    if (strpos(trim($line), 'DB_') === 0) {
        echo trim($line) . PHP_EOL;
    }
}
