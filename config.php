<!-- <?php
if (!defined('BASE_URL')) {
    define('BASE_URL', 'https://mcchmhotelreservation.com');
}
?> -->
<?php
// Define the base URL for your website
if (!defined('BASE_URL')) {
    define('BASE_URL', 'https://mcchmhotelreservation.com');
}

// Define your database configuration constants
defined('DB_SERVER') ? null : define("DB_SERVER", "127.0.0.1"); // or use the correct server IP
defined('DB_USER') ? null : define("DB_USER", "u510162695_hmsystemdb"); // your database username
defined('DB_PASS') ? null : define("DB_PASS", "1Hmsystemdb"); // your database password
defined('DB_NAME') ? null : define("DB_NAME", "u510162695_hmsystemdb"); // your database name
defined('DB_PORT') ? null : define("DB_PORT", 3306); // your database port (default is 3306 for MySQL)

// Optional: Define the server root and web root for easier path management
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];

$webRoot = str_replace(array($docRoot, 'includes/config.php'), '', $thisFile);
$srvRoot = str_replace('config/config.php', '', $thisFile);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);
?>

