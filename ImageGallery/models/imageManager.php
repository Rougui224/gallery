<?php
    require_once('Manager.php');

    class ManagerImage extends Manager {
        private $_uploadDir; // Répertoire où les images seront stockées
        public function getImagesDatas(){
            $db = $this->connection();
            $request = $db->query('SELECT * FROM images_data');
            return $request;
        }
        public function postImageData($file_name, $file_path, $size, $mime_type){
            $db = $this->connection();
            $request = $db->prepare('INSERT INTO images_data(file_name,file_path,size,mime_type) VALUES(?,?,?,?)');
            $result = $request->execute([$file_name, $file_path, $size, $mime_type]);
            return $result;
        }

        // Méthode pour valider l'image
        private function validateTypeImage($file) {
              // Utilisation correcte de pathinfo pour obtenir l'extension du fichier
            $fileInfo = pathinfo($file['name']);
            $mimeType = strtolower($fileInfo['extension']); // Convertir en minuscule pour la cohérence
            $allowedType = ['png', 'gif', 'jpeg', 'jpg', 'webp']; // Extensions autorisées
            return in_array($mimeType, $allowedType); // Vérifie si l'extension est autorisée
        }
        private function validateSizeImage($file){
            return $file['size'] <= 3000000;
        }
       public function upload($file){
    // Vérifier que l'image a été envoyée sans erreur
    if (isset($file) && $file['error'] === 0) {
        if ($this->validateSizeImage($file)) { // Valider la taille
            if ($this->validateTypeImage($file)) { // Valider le type
                // Génération d'un nom unique pour éviter les collisions
                $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $fileName = time() . rand() . rand() . '.' . $fileExtension;

                // Utilisation d'un chemin absolu vers le répertoire de téléchargement
                $uploadDir = __DIR__ . '/../public/uploads/' ;
                $fileLocalPath = $uploadDir . $fileName ;
                $filePath = './../public/uploads/' . $fileName;

                // Vérifier si le dossier existe, sinon le créer
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Crée le dossier avec des permissions appropriées
                }

                // Déplacer le fichier téléchargé vers le dossier spécifié
                if (move_uploaded_file($file['tmp_name'], $fileLocalPath)) {
                    try {
                        // Enregistrer les données de l'image dans la base de données
                        $this->postImageData($fileName, $filePath, $file['size'], $fileExtension);
                    } catch (Exception $e) {
                        throw new Exception("Erreur lors de l'enregistrement dans la base de données : " . $e->getMessage());
                    }
                } else {
                    throw new Exception("Erreur lors du déplacement du fichier téléchargé.");
                }
            }
        }
    }
}
    }