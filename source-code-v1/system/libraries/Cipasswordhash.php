<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cipasswordhash {

    
    function create_hash($password,$key)
    {
        
        $salt1 = hash('sha512', $key . $password);
        $salt2 = hash('sha512', $password . $key);
        $hashed_password = hash('sha512', $salt1 . $password . $salt2);
        return $hashed_password;
    }
    
    function verify_hash($password,$key)
    {
        $salt1 = hash('sha512', $key . $password);
        $salt2 = hash('sha512', $password . $key);
        $hashed_password = hash('sha512', $salt1 . $password . $salt2);
        return $hashed_password;
    }
}