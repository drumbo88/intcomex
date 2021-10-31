<?php 
class MasterModel extends Model {

    function __construct() {
        parent::__construct();
    }

    function init() {
        return [
            'home' => 'Intcomex',
            'acciones' => [
                'Contacto' => 'contacto.php?a=formLoad',
            ]
        ];
    }

}