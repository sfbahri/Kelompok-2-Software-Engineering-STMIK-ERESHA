<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Mpdf {
 
	protected $CI;
 
	public function __construct()	{
 
		include_once APPPATH.'/third_party/mpdf/src/mpdf.php';
		ini_set('memory_limit','1024M');
 
        $CI = &get_instance();
		$CI->pdf = new mPDF($param);
 
		log_message('Debug', 'mPDF class is loaded.'); 
	}
 
}