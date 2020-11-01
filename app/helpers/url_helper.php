<?php

//Simple page direct

function redirect($page){
    header('location: ' . URLROOT . '/'.$page);
}


?>