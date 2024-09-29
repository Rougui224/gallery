<?php 
    class Manager {
        protected function connection(){
            try {
                $database = new PDO('mysql:host=localhost;dbname=images;charset=utf8','root','');
            }catch(Exception $e) {
                throw new Exception('Erreur : '.$e->getMessage());
            }
            return $database;
        }
    }