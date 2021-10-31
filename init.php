<?php 
    require "config.php";
    require "errorHandler.php";
    require "db.php";

    require "controller.php";
    require "models/Model.php";

    define('HOME_ACTION', 'bienvenida');
    if (!isset($_GET['a']))
        $_GET['a'] = HOME_ACTION;

    define('ACTION', isset($_GET['a']) ? $_GET['a'] : '');
    define('IS_POST', $_SERVER["REQUEST_METHOD"] == "POST");

    define('FILE_PATH', $_SERVER['SCRIPT_NAME']);
    define('ROOT_DIR', str_replace(basename(FILE_PATH), '', FILE_PATH));
    define('MODULE', $index ? 'home' : basename(FILE_PATH));
    
    ob_start();
    $controller = Controller::load(MODULE);
    if (ACTION) {
        $exito = $controller->execAction(ACTION);
    }
    $module = ob_get_contents();
    ob_end_clean();

    $master = Controller::load('master');
    $master->execAction('init');
    $master->loadView(null, compact('module','exito','controller'));
    