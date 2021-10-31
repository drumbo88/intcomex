<?php 
    abstract class Controller {

        protected $name;
        protected $script;
        protected $data = [];
        protected $model = null;
        protected $view = null;
        protected $error = null;
        protected $errorData = null;

        static function load($script) {
            $posDot = strpos($script, '.');
            if ($posDot === false) {
                $name = $script;
                $script .= '.php';
            }
            else 
                $name = substr($script, 0, $posDot);

            require_once CONTROLLERS_PATH . $name . ".php";
            $controllerClass = ucfirst($name."Controller");
            return new $controllerClass($name);
        }

        function __construct($name) {
            $this->name = $name;
            $this->script = "$name.php";
            
            require_once MODELS_PATH . $this->script;
            $modelClass = ucfirst($name."Model");
            $this->model = new $modelClass();
        }
        function execAction($action) {
            try {
                if (is_callable([$this,$action]))
                    $data = $this->$action();
                else 
                    $data = $this->model->$action();

                if (is_array($data))
                    foreach ($data as $key => $value)
                        $this->data[$key] = $value;
            }
            catch (Exception $e) {
                $this->error = ErrorHandler::getError();
                $this->errorData = ErrorHandler::getData();
                return false;
            }
            return true;
        }
        function hasView() {
            return $this->view !== false;
        }
        function loadView($view = null, $data = []) {
            foreach ($this->data as $key => $value)
                $data[$key] = $value;
            extract($data);
            if ($view)
                include VIEWS_PATH . $view;
            elseif ($this->view)
                include VIEWS_PATH . $this->view;
            else 
                include VIEWS_PATH . $this->script;
        }
        function getError() {
            return $this->error;
        }
        function getErrorData() {
            return $this->errorData;
        }
        function resetError() {
            $this->error = null;
        }
        
    }