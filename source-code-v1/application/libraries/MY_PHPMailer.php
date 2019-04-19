<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_PHPMailer {
    
    function MY_PHPMailer(){
        
        require_once(APPPATH.'libraries/phpmailer/class.phpmailer.php');
    }
}
?>