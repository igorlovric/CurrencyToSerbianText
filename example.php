<?php
    require_once 'c2t.php';

    for ($x=0; $x<100; $x++) {
        $no=rand(0, PHP_INT_MAX).".".rand(0, 99);
        echo str_pad($no, 20, ' ',STR_PAD_RIGHT ).Currency2Txt($no)."\n";
    }
?>