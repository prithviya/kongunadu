<?php

require_once __DIR__ . '/../config.php';

$tableQuery = "
CREATE TABLE IF NOT EXISTS contact_form (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$mysqli->query($tableQuery);

?>