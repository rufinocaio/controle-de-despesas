<?php

require '../vendor/autoload.php';
require '../app/Database.php';
require '../app/Session.php';

use Pecee\SimpleRouter\SimpleRouter as Router;

// Inicie a sessão
startSession();

// Carregue as rotas
require '../src/routes.php';