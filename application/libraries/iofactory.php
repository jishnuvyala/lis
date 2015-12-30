<?php

if (!defined('BASEPATH'))     exit('No direct script access allowed');
require_once APPPATH . "/third_party/PHPWord/IOFactory.php";
/*
 * PHPExcel Lib For CI
 *
 * Class Excel
 *
 * Using PHP Excel Class
 */
class Iofactory extends PHPWord_IOFactory {
    public function __construct() {
    }
}
?>