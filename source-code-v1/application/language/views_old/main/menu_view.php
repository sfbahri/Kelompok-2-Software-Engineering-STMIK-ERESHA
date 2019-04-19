<ul class="br-sideleft-menu">
<?php
foreach($modules as $mod){
    if($mod['position']==1 and $mod['have_child']=='Y'){

        echo '<li class="br-menu-item">
                  <a href="javascript:void(0)" class="br-menu-link with-sub">
                    <i class="menu-item-icon icon ion-'.$mod['icon'].' tx-24"></i>
                    <span class="menu-item-label">'.$mod['name'].'</span>
                  </a>
                  <ul class="br-menu-sub">';
                      foreach($modules as $d){
                            if($d['position']==2 and $d['have_child']=='N' and $d['parent'] == $mod['id']){

                                echo '<li class="sub-item"><a href="javascript:void(0)" onclick=getcontents("'.$d['controller'].'","'.$this->session->userdata('sess_token').'"); class="sub-link"> '.$d['name'].' </a></li>';
                            }
                        }
                    
                  echo '</ul>
                </li>';

    }
    else if($mod['position']==1 and $mod['have_child']=='N'){

            echo'<li class="br-menu-item">
                  <a href="javascript:void(0)" onclick=getcontents("'.$mod['controller'].'","'.$this->session->userdata('sess_token').'") class="br-menu-link">
                    <i class="menu-item-icon icon ion-'.$mod['icon'].' tx-24"></i>
                    <span class="menu-item-label"> '.$mod['name'].'</span>
                  </a>
                </li>';

    }else{
        
    }
}
?>    
</ul> 
