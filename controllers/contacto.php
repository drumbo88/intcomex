<?php 
class ContactoController extends Controller {

    function formLoad() {
        $this->data = $this->model->formLoad();
        $this->loadView('contacto-form.php');
    }
    function formSubmit() {
        try {
            $this->data = $this->model->formSubmit();
            // Si no hubo errores, redirecciono al Home.
            Controller::load("home")->execAction(HOME_ACTION);
        }
        catch (Exception $e) {
            // Si hubo errores, vuelvo a cargar el formulario.
            $this->formLoad();
            return ErrorHandler::throw();
        }
        return true;
    }
}