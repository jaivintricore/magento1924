<?php

$localXml = __DIR__ .'/../../app/etc/local.xml';

if (file_exists($localXml)) {

    // Load in the local.xml and retrieve the database settings
    $xml = simplexml_load_file($localXml);

    if (isset($xml->global->resources->default_setup->connection)) {
        $connection = $xml->global->resources->default_setup->connection;

        // ** MySQL settings - You can get this info from your web host ** //
        /** The name of the database for WordPress */
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

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {die("Unable to connect to Database");}

// Select base URL from database
$coreConfigData = "mgn_core_config_data";
$sql            = "select value from ".$coreConfigData." where ".$coreConfigData.".path = 'web/unsecure/base_url' and scope_id = 0 and scope = 'default'";
$result         = $db->query($sql);
while ($row = $result->fetch_assoc()) {
    $baseUrl = $row['value'];
    break;
}
