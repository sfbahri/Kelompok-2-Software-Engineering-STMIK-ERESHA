<br>
<h4 class="page-header">Lowongan Posisi</h4>
<hr>

<?php 
    foreach ($w_posisi_list as $s) {
        echo '<a href='.base_url('webmain/apply/'.$s['id'].'').'>'.$s['nama_posisi'].'</a><p>';
    }
?>