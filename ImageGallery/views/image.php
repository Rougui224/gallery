<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader et afficher des images</title>
    <link rel="stylesheet" href="./../public/design/style.css">
</head>
<body>

<div class="container">
    <h1>Uploader une Image</h1>
    <form class="upload-form" action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" required>
        <button type="submit">Uploader l'image</button>
    </form>

    <div class="gallery">
        <h2>Galerie des images</h2>
        <!-- La galerie des images sera chargée ici -->
        <div class="gallery-grid">
        </div>
         
        <?php
        // Charger les images depuis la base de données
         while ($row = $result->fetch()) {
                echo '<div class="image-card">';
                echo '<img src="' . $row['file_path'] . '" alt="' . $row['file_name'] . '">';
                echo '<p> <b>URL</b> : https://localhost/public/uploads/' . $row['file_name'] . '</p>';
                echo '</div>';
            }
        ?>
    </div>
</div>

</body>
</html>
