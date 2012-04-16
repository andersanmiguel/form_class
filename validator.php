<?php 

class Validator {

    public $ok;
    private $errors = array();
    private $message;

    function __construct($fields, $values) {
        foreach($fields as $field) {
            if(isset($field['validation_rules'])){
                if(isset($field['validation_rules']['required'])) {
                    if($this->validate_empty($values[$field['name']])) {
                        // Not empty
                        if(isset($field['validation_rules']['type'])) {
                            $type = $field['validation_rules']['type'];
                            $args = isset($field['validation_rules']['args']) ? $field['validation_rules']['args']: '';
                            if($this->$type($values[$field['name']], '', $args)) {
                               // ok 
                            } else {
                                $this->setError($field['name'], $this->message);
                                $this->message = '';
                                unset($values[$field['name']]);
                            }
                        }
                    } else {
                        // Empty
                        $this->setError($field['name'], $this->message);
                        $this->message = '';
                        unset($values[$field['name']]);
                    }
                }
            }
        }

    }

    function validate_empty($field, $message = '') {
        if($message == '') {
            $message = $this->_message('empty');
        }
        if(empty($field)) {
            $this->message = $message;
            return false;
        }

        return true;
    }

    function string($field, $message = '', $length = '') {
        if($message == '') {
            if($length == '') {
                $message = $this->_message('string');
                return false;
            } else {
                $limits = explode('-', $length);
                if(count($limits) > 1) {
                    $min = $limits[0];
                    $max = $limits[1];
                } else {
                    $min = 1;
                    $max = $limits[0];
                }

                if(strlen($field) < $min || strlen($field) > $max) {
                    $message = $this->_message('strlen');
                } 

            }
        }

        if($message != '') {
            $this->message = $message;
            return false;
        }

        return true;
    }

    private function setError($key, $value) {
        $this->errors[$key] = $value;
    }

    private function getErrors($key = '') {
        if($key != '') {
            return $this->errors[$key];
        } else {
            return $this->errors;
        }
    }

    private function _message($condition) {
        
        switch ($condition) {
            case 'empty':
                $message = $this->l('El campo no puede estar vacío');
                break;
            
            case 'string':
                $message = 'El campo debe ser una cadena de texto';
                break;
            
            case 'strlen':
                $message = 'El campo debe ser una cadena de texto de entre 5 y 12 caracteres';
                break;
            
            default:
                // code...
                $message = 'Error en el campo del formulario';
                break;
        }
        

        return $message;
    }

    function fail_validator() {

        $errores = $this->getErrors();

        if(empty($errores)) {
            // OK
            // echo 'Yeah!';
            return true;
        } else {
            // echo '<pre>';
            // print_r($errores);
            // echo '</pre>';
            return $errores;
        }
    }

    function l($message) {
        return $message;
    }

    


}
