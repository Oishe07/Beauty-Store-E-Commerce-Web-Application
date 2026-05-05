<?php
$input_password = 'admin123';
$stored_hash = '$2y$10$ZfvtdqnLg66I/jyYZoEqOOaG5jvGx81OwIirnrrgyXLFKY9L0HtTO'; // should match admin123

if (password_verify($input_password, $stored_hash)) {
    echo "✅ Password matches!";
} else {
    echo "❌ Password does NOT match!";
}
?>
