<?php

function sanitize($before){
    foreach($before as $key=>$val){
        $after[$key]=htmlspecialchars($val,ENT_QUOTES,'UTF-8');
    }
    return($after);
}
?>