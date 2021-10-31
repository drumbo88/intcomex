<?php 
class HomeModel extends Model {

    function __construct() {
        parent::__construct();
    }

    function bienvenida() {
        return ['titulo' => 'Home'];
    }

}