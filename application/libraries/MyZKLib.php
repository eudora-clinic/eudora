<?php
require_once APPPATH . 'libraries/zklib/ZKLib.php';

class MyZKLib extends ZKLib {
    public function __construct($ip, $port) {
        parent::__construct($ip, $port);
    }
}
?>
