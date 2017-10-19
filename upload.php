<?php

require  'functions.php';
require_once 'config.php';

if (!empty($_FILES['myfile'])) {
    if ($_FILES['myfile']['error'] === UPLOAD_ERR_OK) {

        $errorMessages = [];


        $fileTemporaryName = $_FILES['myfile']['tmp_name'];
        $originalFileName = cleanFileName(basename($_FILES['myfile']['name']));
        $fileMimeType = $_FILES['myfile']['type'];
        $friendlyFileSize = bytesToSize1024($_FILES['myfile']['size'], 1);

        // On récupère l'extension du fichier par son type mime (ce qui est plus sûr que de la
        // récupérer depuis le nom du fichier car elle peut être facilement modifiée par l'utilisateur).
        $fileExtension = getSupportedExtension($fileMimeType);
        // Si l'extension n'est pas supportée par notre application la fonction 'getSupportedExtension' retourne false.
        if (!$fileExtension) {
            $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $errorMessages[] = "Le format du fichier (.$extension) n'est pas supporté.";
        }

        // Vérification de la taille du ficher
        if ($_FILES['myfile']['size'] > 2000000) {
            $friendlyMaxSize = bytesToSize1024(MAX_SIZE);
            $errorMessages[] = "Le fichier est trop grand ($friendlyFileSize), il ne doit pas dépasser $friendlyMaxSize";
        }

        if (empty($errorMessages)) {
            $newFileName = 'image' . uniqid() . '.' . $fileExtension;

            $filePath = UPLOAD_DIR . $newFileName;

            if (move_uploaded_file($fileTemporaryName, $filePath)) {
                echo <<<EOF
<div class="s">
    <p>Le fichier '{$originalFileName}' a été correctement transféré.</p>
    <p>Type : {$fileMimeType}</p>
    <p>Taille : {$friendlyFileSize}</p>
    <img class="img-fluid" src="{$filePath}">
</div>
EOF;
            } else {
                echo '<div class="f">Impossible de téléchargé le fichier \''
                    . $originalFileName .
                    '\', veuillez réesayez s\'il vous plait.';
            }
        } else {
            $message =  '<div class="f">' .
                "\n\t<p>Attention le fichier '$originalFileName' n'a pas été téléchargé car il ne respecte pas les réglementations de l'envoie du fichier:</p>";

            foreach ($errorMessages as $errorMessage) {
                $message .= "\n\t<p>$errorMessage</p>";
            }
            $message .= '</div>';

            echo $message;
        }


    } else {
        $errorMessage = getUploadErrorMessage($_FILES['myfile']['error'], $_FILES['myfile']['name']);
        echo '<div class="f">Une erreur s\'est produite: ' . $errorMessage . '</div>';
    }
}
