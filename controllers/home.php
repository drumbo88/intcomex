<?php 
class HomeController extends Controller {

    function bienvenida() {
        $this->data = $this->model->bienvenida();
        $this->loadView();
    }
}