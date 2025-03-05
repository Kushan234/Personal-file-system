<?php

if (isset($_POST['username'])) {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    
    $alertFile = 'alerts/alert.txt';
    
    if (!file_exists('alerts')) {
        mkdir('alerts', 0777, true);
    }
    
    file_put_contents($alertFile, $username . "\n", FILE_APPEND | LOCK_EX);
    
    echo json_encode(['status' => 'success', 'message' => 'Alert sent from ' . $username]);
} else {
    
    echo json_encode(['status' => 'error', 'message' => 'Username not provided']);
}
?>
