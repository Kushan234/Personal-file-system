<?php

header('Content-Type: application/json');

$alertFile = 'alerts/alert.txt';

$alerts = [];


if (file_exists($alertFile)) {
    $fileContents = file_get_contents($alertFile);
    $alerts = array_filter(array_map('trim', explode("\n", $fileContents)));
    
    file_put_contents($alertFile, '');
}

if (!empty($alerts)) {
    echo json_encode([
        'new_alert' => true,
        'alerts' => $alerts
    ]);
} else {
    echo json_encode(['new_alert' => false]);
}
?>
