<?php
require_once APPPATH . 'libraries/TCPDF/tcpdf.php';

class Ltcpdf extends TCPDF {
    public function __construct() {
        parent::__construct();
    }
}
?>
