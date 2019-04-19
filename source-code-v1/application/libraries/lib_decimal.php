<?php
class Lib_decimal {
   
   
    public function __construct() {
     
    }


   function replaceto($angka){
       
        $str_nilai = str_replace('.', '', $angka);
        $str_fix_nilai = str_replace(',', '.', $str_nilai);
       
        return $str_fix_nilai;
        
    }


}