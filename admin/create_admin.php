<?php
// run once from browser: http://localhost/newsletter-project/admin/create_admin.php
require_once __DIR__ . '/../config.php';

$username = 'admin';
$password = 'admin123'; // change immediately
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admins (username,password) VALUES (?, ?)");
$stmt->bind_param('ss', $username, $hash);
if ($stmt->execute()) {
    echo "Admin created: $username (password: $password). DELETE this file now!";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();

?>
