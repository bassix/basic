<?php

// Check PHP version

$requiredPhpVersion = '8.0.0';

if (version_compare(PHP_VERSION, $requiredPhpVersion, '<')) {
    die("PHP version must be at least $requiredPhpVersion. Current version: " . PHP_VERSION . "<br>\n");
} else {
    echo "PHP version is sufficient: " . PHP_VERSION . "<br>\n";
}

// Required PHP extensions

$extensions = ['gd', 'json', 'mbstring', 'mysqli', 'pdo_mysql', 'zip', 'openssl', 'intl', 'bcmath', 'gmp', 'simplexml', 'curl', 'xml', 'posix', 'exif', 'iconv'];

foreach ($extensions as $ext) {
    if (!extension_loaded($ext)) {
        echo "Missing required PHP extension: $ext<br>\n";
    } else {
        echo "PHP extension $ext is installed.<br>\n";
    }
}

// Check memory limit

$memoryLimit = ini_get('memory_limit');
$memoryLimitBytes = preg_replace('/[^0-9]/', '', $memoryLimit) * 1024 * 1024;

if ($memoryLimitBytes < 512 * 1024 * 1024) {
    echo "Warning: Memory limit should be at least 512M. Current: $memoryLimit<br>\n";
} else {
    echo "Memory limit is sufficient: $memoryLimit<br>\n";
}

// Check max file upload size

$uploadMaxSize = ini_get('upload_max_filesize');
echo "Max file upload size: $uploadMaxSize<br>\n";

// Check database connection (modify credentials as needed)

$servername = "localhost";
//$servername = "127.0.0.1";
$username = "basic";
$password = "Qy184Zloj6Jt";
$database = "basic";

//$mysqli = @new mysqli('localhost', 'your_username', 'your_password', 'your_database');
$mysqli = @new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    echo "Database connection failed: " . $mysqli->connect_error . "<br>\n";
} else {
    echo "Database connection successful.<br>\n";
    $mysqli->close();
}
