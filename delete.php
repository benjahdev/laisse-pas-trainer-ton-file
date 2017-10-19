<?php

require 'config.php';

if (!empty($_POST["file_name"])) {
    if (file_exists(UPLOAD_DIR . $_POST["file_name"])) {
        unlink(UPLOAD_DIR . $_POST["file_name"]);
    }
}

header('Location: index.php');