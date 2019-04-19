<?php
switch ($webkonten) {
    case "home":
        echo $this->load->view('webkonten/home_view');
        break;
    case "posisi":
        echo $this->load->view('webkonten/posisi_view');
        break; 
    case "apply":
        echo $this->load->view('webkonten/apply_view');
        break;     
        
    default:
        echo "Your favorite color is neither red, blue, nor green!";
}
?> 