<?php

    require_once("./controllers/image.php");
    try {
        addImageData();
        getImagesDatas();

    }catch(Exception $e){
        $error = $e->getMessage();
        require('views/errorView.php');
    }