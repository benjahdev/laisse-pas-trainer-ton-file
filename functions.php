<?php

require_once 'config.php';

function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}

function getUploadErrorMessage(int $errorCode, string $fileName) : string {
    $phpFileUploadErrors = array(
        0 => 'Il n\'y a pas d\'erreur, le fichier a été téléchargé avec succès.',
        1 => 'Le fichier \'' . $fileName . '\' dépasse la directive upload_max_filesize dans \'php.ini\'.',
        2 => 'Le fichier \'' . $fileName . '\' dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML.',
        3 => 'Le fichier \'' . $fileName . '\' n\'a été que partiellement téléchargé.',
        4 => 'Aucun fichier n\'a été téléchargé.',
        6 => 'Le fichier \'' . $fileName . ' ne peut pas être téléchargé car il manque un dossier temporaire sur le serveur.',
        7 => 'Impossible d\'écrire le fichier \'' . $fileName . '\' sur le disque.',
        8 => 'Une extension PHP a arrêté le téléchargement du fichier \'' . $fileName . '\'.',
    );

    return $phpFileUploadErrors[$errorCode];
}

function getSupportedExtension(string $mimeType) {
    $extension = false;

    if (array_key_exists($mimeType, ALLOWED_EXTENSIONS)) {
        $extension = ALLOWED_EXTENSIONS[$mimeType];
    }

    return $extension;
}

function cleanFileName(string $fileName) : string
{
    //On remplace les lettres accentutées par les non accentuées dans $fichier.
    //Et on récupère le résultat dans fichier
    $fileName = strtr($fileName,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');


    //En dessous, il y a l'expression régulière qui remplace tout ce qui n'est pas une lettre non accentuées ou un chiffre
    //dans $fileName par un tiret "-" et qui place le résultat dans $result.
    $result = preg_replace('/([^.a-z0-9]+)/i', '-', $fileName);

    return $result;
}
