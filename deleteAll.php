<?php

require 'config.php';

$files = new FilesystemIterator(UPLOAD_DIR);

foreach ($files as $file) {
    unlink($file);
}

header('Location: index.php');
