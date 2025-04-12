<?php
require './get_fcm_token.php';
require './send_notification.php'; // Your existing notification file

$testToken = "cpL43TGnQe-0DaWmDEXVhd:APA91bGeiRNXwD8HqjIq4qE4KEG8SXwjWtPlWlk0uxarFWNosARhEgva3ioSnOnoJWI5_Wv3OXh9o-Yy0pvr_SAhwfnSE-bB2DjELt8C8A3HtldkEG-9obI";

$result = sendPushNotification(
    $testToken,
    "Token Test",
    "Testing direct token delivery"
);

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);