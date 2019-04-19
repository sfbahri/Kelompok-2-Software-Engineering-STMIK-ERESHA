<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_label extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    }

    public function coba(){
        
        $this->load->library("EscPos");

        try {
                        // Enter the device file for your USB printer here
            $connector = new Escpos\PrintConnectors\FilePrintConnector("C:/ZD5-1-16-6849/ZBRN/ZebraFD");

            /* Print a "Hello world" receipt" */
            $printer = new Escpos\Printer($connector);
            $printer -> text("Hello World!");
            $printer -> cut();

            /* Close printer */
            $printer -> close();

            echo "Status Print : oke ";
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }
    
}
