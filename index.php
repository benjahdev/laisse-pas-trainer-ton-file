<?php
require_once 'config.php';
require 'functions.php';

$files = new FilesystemIterator(UPLOAD_DIR);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>MEGAUPLOAD 2.0 - Laisse pas trainer ton file</title>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>
<body>
<header>
    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img src="images/mega-upload-2.0.jpg" height="40" alt="">
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Acceuil<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Premium</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="container-fluid">
    <div class="contr"><h2>Glissez et déposez vos fichiers dans la «&#160;zone de drop&#160;» (Maximum <?= MAX_FILES ?> fichiers - taille maximale par fichier <?= bytesToSize1024(MAX_SIZE) ?></h2></div>
    <div class="upload_form_cont">
        <div id="dropArea">Déposer vos files ici!</div>
        <div id="infoBox" class="hidden">
            <div>Fichiers restants : <span id="count">0</span></div>
            <a href="index.php" class="btn btn-primary float-right mr-3">Effacer les résultats</a>
            <canvas width="250" height="20"></canvas>
            <div id="result"></div>
        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <a href="deleteAll.php" class="btn btn-primary btn-danger float-right mr-3 mb-3">Effacer tout</a>
                <a href="index.php" class="btn btn-primary float-right mr-3 mb-3">Actualiser</a>
                <h3>Mes images téléchargées:</h3>
            </div>
        </div>
        <div class="row">
            <?php
            $id = 0;
            foreach ($files as $file) :
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                if (!in_array($extension, ALLOWED_EXTENSIONS)) {
                    continue;
                }
                ?>
                <div class="col">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="<?= UPLOAD_DIR . $file->getFileName(); ?>" alt="Card image cap">
                        <div class="card-block">
                            <h4 class="card-title"><?= $file->getFileName(); ?></h4>
                            <form method="post" action="delete.php" class="form-inline">
                                <input type="hidden" name="file_name" value="<?= $file->getFileName(); ?>">
                                <button type="button" class="btn btn-primary mr-3" data-toggle="modal" data-target="#myModal_<?= $id; ?>">Aperçu</button>
                                <button type="submit" class="btn btn-secondary btn-danger">Effacer</button>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal fade bd-example-modal-lg" id="myModal_<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_<?= $id; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel_<?= $id ?>"><?= $file->getFileName(); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img class="img-fluid" src="<?= UPLOAD_DIR . $file->getFileName(); ?>" alt="Image cap">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            $id++;
            endforeach;
            if ($id == 0) : ?>
                <div class="col">
                    <p>Pas d'images dans votre bibliothèque =(</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="//www.youtube.com/embed/biYdUZXfz9I?rel=0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>var maxFiles = <?= MAX_FILES ?>;</script>
<script src="js/script.js"></script>
</body>
</html>