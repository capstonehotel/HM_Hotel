<!-- <?php
if (!defined('BASE_URL')) {
    define('BASE_URL', 'https://mcchmhotelreservation.com');
}

// Database Constants
defined('DB_SERVER') ? null : define("DB_SERVER", "127.0.0.1");
defined('DB_USER') ? null : define("DB_USER", "u510162695_hmsystemdb");
defined('DB_PASS') ? null : define("DB_PASS", "1Hmsystemdb");
defined('DB_NAME') ? null : define("DB_NAME", "u510162695_hmsystemdb");
defined('DB_PORT') ? null : define("DB_PORT", 3306);

$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot = str_replace(array($docRoot, 'includes/config.php'), '', $thisFile);
$srvRoot = str_replace('config/config.php', '', $thisFile);
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);
?>
