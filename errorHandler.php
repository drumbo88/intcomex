<?php
    class ErrorHandler {

        static private $error;
        static private $data;

        static function throw($msg = null, $data = null) {
            if ($msg)
                self::$error = $msg;
            if ($data)
                self::$data = $data;
            throw new Exception($msg);
        }
        static function getError() {
            return self::$error;
        }
        static function getData() {
            return self::$data;
        }
        static function reset() {
            self::$error = null;
            self::$data = null;
        }
    }