<?php

// Fixe le niveau de rapport d'erreur (php >= 5.3)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Taille maximum du fichier
const MAX_SIZE = 1000000;

// Répertoire des images uploadées
const UPLOAD_DIR = 'upload/';

// Maximum de fichiers
const MAX_FILES = 55;

const ALLOWED_EXTENSIONS = [
    'image/jpeg' => 'jpeg',
    'image/gif' => 'gif',
    'image/png' => 'png'
];