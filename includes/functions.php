<?php

function redirect_to($location=NULL){
    if($location != NULL){
        header("Location: {$location}");
        exit;
    }
}

function include_layout_template($template=""){
    include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

?>