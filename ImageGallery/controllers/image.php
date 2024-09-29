<?php
    require_once('./models/imageManager.php');


    function getImagesDatas(){
        $imageManager = new ManagerImage();
        $result = $imageManager->getImagesDatas();
        require_once('./views/image.php');
    }
    function addImageData(){
        $imageManager = new ManagerImage();
        if(!empty($_FILES['image'])) {
            if($imageManager->upload($_FILES['image'])) {
                header('location: index.php');
                exit();
            }
        }
        
        
        
    }