<?php
//ob_start();
//session_start();

$path = $_SERVER['DOCUMENT_ROOT'];//.DIRECTORY_SEPARATOR.'NewDollsKill';
require_once $path.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Mage.php';
Mage::app();
Mage::getSingleton('core/session', array('name' => 'frontend'));
$url = Mage::getBaseUrl();
$url = str_replace("/index.php", "", $url);
define('BASE_URL', $url);

$localXml =  $path.DS.'app'.DS.'etc'.DS.'local.xml';
if (file_exists($localXml)) {
    // Load in the local.xml and retrieve the database settings
    $xml = simplexml_load_file($localXml);

    if (isset($xml->global->resources->default_setup->connection)) {
        $connection = $xml->global->resources->default_setup->connection;

        // ** MySQL settings - You can get this info from your web host ** //
        /** The name of the database */
        define('DB_NAME', $connection->dbname);

        /** MySQL database username */
        define('DB_USER', $connection->username);

        /** MySQL database password */
        define('DB_PASSWORD', $connection->password);

        /** MySQL hostname */
        define('DB_HOST', $connection->host);

    }
} else {
    die('Unable to load Magento local.xml');
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {die("Unable to connect to Database");}
$_SESSION['conn'] = $conn;

// get country
if (!isset($_SESSION['country_id'])) {
    $countryId = GeoIP_Core::getInstance(Mage::getBaseDir('media') . DS . "geoip" . DS . "GeoLiteCity.dat", GeoIP_Core::GEOIP_STANDARD)
        ->geoip_country_code_by_addr(Mage::helper('core/http')->getRemoteAddr());
    if (!$countryId) {
        $countryId = "US";
    }
    $_SESSION['country_id'] = $countryId;
}

// get magento attribute_id - for name, price, special_price, small_image
if (!isset($_SESSION['attribute_id_name']))
    $_SESSION['attribute_id_name'] = getAttributeId('name');
if (!isset($_SESSION['attribute_id_display_brand']))
    $_SESSION['attribute_id_display_brand'] = getAttributeId('display_brand');
if (!isset($_SESSION['attribute_id_price']))
    $_SESSION['attribute_id_price'] = getAttributeId('price');
if (!isset($_SESSION['attribute_id_special_price']))
    $_SESSION['attribute_id_special_price'] = getAttributeId('special_price');
if (!isset($_SESSION['attribute_id_small_image']))
    $_SESSION['attribute_id_small_image'] = getAttributeId('small_image');
if (!isset($_SESSION['attribute_id_whole_preorder']))
    $_SESSION['attribute_id_whole_preorder'] = getAttributeId('whole_preorder');
if (!isset($_SESSION['attribute_id_preorder_shipping_date']))
    $_SESSION['attribute_id_preorder_shipping_date'] = getAttributeId('preorder_shipping_date');

// get base URL for product's image
if (!isset($_SESSION['base_image_url'])) {
    $sql = "SELECT value FROM mgn_core_config_data WHERE path='retailops_settings/cdn/unsecure_base_url'";
    $resultUrl = $conn->query($sql);
    if ($resultUrl->num_rows > 0) {
        $row = $resultUrl->fetch_assoc();
        $_SESSION['base_image_url'] = $row['value'];
    }
}

function getAttributeId($attribute) {
    $conn = $_SESSION['conn'];
    $sql = "SELECT ea.attribute_id FROM mgn_eav_attribute AS ea WHERE ea.entity_type_id = 4 AND ea.attribute_code='".$attribute."'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["attribute_id"];
    }
    else {
        return 0;
    }
}