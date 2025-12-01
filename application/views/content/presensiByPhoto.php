<html>

<head>
    <title>ZK Test</title>
</head>

<body>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $enableGetDeviceInfo = true;
    $enableGetUsers = true;
    $enableGetData = true;

    require_once APPPATH . 'libraries/MyZKLib.php';

    $zk = new ZKLib(
        '192.168.8.17'
    );

    $ret = $zk->connect();
    echo $ret;
    if ($ret) {
        $zk->disableDevice();
        $zk->setTime(date('Y-m-d H:i:s'));
        
        $zk->enableDevice();
        $zk->disconnect();

        echo "Success to connect.";
    } else {
        echo "Failed to connect.";
    }
    ?>
</body>

</html>