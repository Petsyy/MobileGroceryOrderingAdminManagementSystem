<?php
$password = 'charlie123';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

echo "Hashed Password: " . $hashedPassword;
?>