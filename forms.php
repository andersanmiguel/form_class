<?php 
/**
 * Forms 
 * 
 */
class Forms {

    /**
     * form 
     * 
     * @var array
     * @access protected
     */
    protected $form;
    /**
     * values 
     * 
     * @var array
     * @access protected
     */
    protected $values;
    /**
     * errors 
     * 
     * @var array
     * @access protected
     */
    protected $errors;
    /**
     * form_method 
     * 
     * @var string
     * @access protected
     */
    protected $form_method;
    /**
     * form_action 
     * 
     * @var string
     * @access protected
     */
    protected $form_action;
    /**
     * html 
     * 
     * @var string
     * @access protected
     */
    protected $html;
    /**
     * show_errors 
     * 
     * @var bool
     * @access public
     */
    public $show_errors = false;
    /**
     * error_position 
     * 
     * @var string
     * @access public
     */
    public $error_position = 'after';

    /**
     * __construct
     * 
     * @param array $form 
     * @param array $values 
     * @param array $errors 
     * @access public
     * @return object
     */
    public function __construct($form = array(), $values = array(), $errors = array()) {
        
        isset($form) ? $this->set_form_array($form) : '';
        isset($values) ? $this->set_form_values($values) : '';
        isset($errors) ? $this->set_form_errors($errors) : '';

    }
    

    /**
     * set_form_errors
     * 
     * @param array $errors 
     * @access public
     * @return object Forms class
     */
    public function set_form_errors($errors = array()) {

        if (!empty($errors)) {
            if (is_array($errors)) {
                $this->errors = $errors;
            } else {
                $this->definition_error('formulario incompleto');
            }
        }

        return $this;
        
    }
    

    /**
     * set_form_values
     * 
     * @param bool $values 
     * @access public
     * @return void
     */
    public function set_form_values($values = array()) {

        if (!empty($values)) {
            if (is_array($values)) {
                $this->values = $values;
            } else {
                $this->definition_error('formulario incompleto');
            }
        }

        return $this;
        
    }
    

    /**
     * set_form_array
     * 
     * @param bool $form 
     * @access public
     * @return void
     */
    public function set_form_array($form = array()) {

        if (!empty($form)) {
            if (is_array($form)) {
                $this->form = $form;
            } else {
                $this->definition_error('formulario incompleto');
            }
        }

        if (isset($form['definition'])) {
            $this->parse_form_definition($form['definition']);
        }

        return $this;
        
    }
    

    /**
     * is_fieldset
     * 
     * @param mixed $array 
     * @access private
     * @return void
     */
    private function is_fieldset($array) {

        if (isset($array['fieldset']) && $array['fieldset'] === true) {
            return true;
        } else {
            return false;
        }

    }
    

    /**
     * parse_form_definition
     * 
     * @param mixed $form_definition 
     * @access public
     * @return void
     */
    public function parse_form_definition($form_definition) {

        if (!is_array($form_definition)) {
            return false;
        }

        // Assign method
        $this->assign_method($form_definition['method']);
        // Action
        if (!isset($form_definition['action'])) {
            $this->set_action('#');
        } else {
            $this->set_action($form_definition['action']);
        }

        return $this;

    } 
    

    /**
     * assign_method
     * 
     * @param string $method 
     * @access public
     * @return void
     */
    public function assign_method($method = '') {
        
        if (strtolower($method) == 'get') {
            $this->form_method = strtoupper($method);
        } else {
            $this->form_method = 'POST';
        }        

        return $this;
    }
    

    /**
     * set_action
     * 
     * @param mixed $action 
     * @access public
     * @return void
     */
    public function set_action($action) {
        $this->form_action = $action;

        return $this;
    }
    

    /**
     * label
     * 
     * @param mixed $form_field 
     * @param string $label_text 
     * @param bool $args 
     * @access public
     * @return void
     */
    public function label($form_field, $label_text = '', $args = array()) {

        // <label for="$form_field" $args? > 
        // $label_text || ucfirst($form_field) 
        // </label>

        $htm = '';
        $args_str = '';

        if (!empty($args)) {
            $args_str = $this->attributes($args);
        }

        $html = '<label for="'.$form_field.'"'.$args_str.'>';
        $html .= $label_text != '' ? $label_text : ucfirst($form_field);
        $html .= '</label>';
 
        return $html;

    }

    /**
     * input
     * 
     * @param string $name 
     * @param string|array $args 
     * @access public
     * @return void
     */
    public function input($name, $args = array()) {
    
        // <input name="$name" id="$name" type="$args[type] || text" attributes($args)/>
        $html = '';
        
        $html .= '<input name="'.$name.'"';

        if (is_array($args) && isset($args['id'])) {
            $id = $args['id'];
            unset($args['id']);
        } else {
            $id = $name;
        }
        $html .= ' id="'.$id.'"';

        if (is_array($args) && isset($args['type'])) {
            $type = $args['type'];
            unset($args['type']);
        } else {
            $type = 'text';
        }
        $html .= ' type="'.$type.'"';

        if (isset($this->values[$name])) {
            $html .= ' value="'.$this->values[$name].'"';
        }

        $args = !empty($args) ? $this->attributes($args) : '';
        $html .= $args;
        $html .= ' />';

        if ($this->show_errors == true && isset($this->errors[$name])) {
            $errors = '<span class="form-error">'.$this->errors[$name].'</span>';
            $html .= $errors;
        }

        return $html;

    }

    /**
     * textarea
     * 
     * @param string $name 
     * @param string|array $args 
     * @access public
     * @return string
     */
    public function textarea($name, $args = array()) {

        // <textarea name="$name" id="$name" $args>$this->values[$name]</textarea>
        $html = '';
        
        $html .= '<textarea name="'.$name.'"';

        if (is_array($args) && isset($args['id'])) {
            $id = $args['id'];
            unset($args['id']);
        } else {
            $id = $name;
        }
        $html .= ' id="'.$id.'"';

        $args = !empty($args) ? $this->attributes($args) : '';
        $html .= $args;
        $html .= '>';

        if (isset($this->values[$name])) {
            $html .= $this->values[$name];
        }

        $html .= '</textarea>';


        return $html;
    }

    /**
     * checkbox
     * 
     * @param string $name 
     * @param string|array $value 
     * @param string|array $args 
     * @access public
     * @return $string
     */
    public function checkbox($name, $value, $args = array()) {

        /* ToDo:
            Think about errors and how display them
         */

       
        // <input type="checkbox" name="$name|$name[]" id="id" value="$value" 
        $html = '';
        $multiple = '';

        $args = !empty($args) ? $this->attributes($args) : '';
        if (is_array($value)) {

            $i = 0;
            foreach ($value as $val) {
                if (is_array($args) && isset($args['id'])) {
                    $id = $args['id'].$i;
                    unset($args['id']);
                } else {
                    $id = $name.$i;
                }
                $i++;

                $html .= '<input type="checkbox" name="'.$name.'[]"'; 
                $html .= ' id="'.$id.'" '.$args.' value="'.$val.'"'.$args.' />';
            }

        } else {
            if (is_array($args) && isset($args['id'])) {
                $id = $args['id'];
                unset($args['id']);
            } else {
                $id = $name;
            }

            $html .= '<input type="checkbox" name="'.$name.'"'; 
            $html .= ' id="'.$id.'" '.$args.' value="'.$value.'"'.$args.' />';
        }

        return $html;

    }
    
    public function checkbox($name, $values, $args = array()) {

        // <select name="$name|$name[]" $args>
        // foreach $values
        // <option value=$value[val]>$value[name|value]</option>
        // </select>
        $html = '';
        $multiple = '';

        $args = !empty($args) ? $this->attributes($args) : '';
        if (is_array($value)) {

            $i = 0;
            foreach ($value as $val) {
                if (is_array($args) && isset($args['id'])) {
                    $id = $args['id'].$i;
                    unset($args['id']);
                } else {
                    $id = $name.$i;
                }
                $i++;

                $html .= '<input type="checkbox" name="'.$name.'[]"'; 
                $html .= ' id="'.$id.'" '.$args.' value="'.$val.'"'.$args.' />';
            }

        } else {
            if (is_array($args) && isset($args['id'])) {
                $id = $args['id'];
                unset($args['id']);
            } else {
                $id = $name;
            }

            $html .= '<input type="checkbox" name="'.$name.'"'; 
            $html .= ' id="'.$id.'" '.$args.' value="'.$value.'"'.$args.' />';
        }

        return $html;

    }
    
    
    
    /**
     * Build a HTML string of attributes
     * 
     * @param array|string $args 
     * @access protected
     * @return string
     */
    protected function attributes($args) {
        
        // id="value" id2="value2" id3 
        $html = '';

        if (!is_array($args)) {
            return ' '.$args.'="'.$args.'"';
        }
        
        foreach ($args as $id => $val) {
            if (gettype($id) == 'string') {
                $html .= $id.'="'.$val.'" ';
            } else {
                $html .= $val.'="'.$val.'" ';
            }
        }

        $html = ' '.trim($html);

        return $html;

    }
    
    /**
     * definition_error
     * 
     * @param mixed $type_error 
     * @access public
     * @return void
     */
    public function definition_error($type_error) {
        echo 'Error en la definición del formulario: '.$type_error;die;
    }

    /**
     * render
     * 
     * @access public
     * @return string
     */
    public function render() {
        echo '<pre>';
        print_r($this->form);
        echo '</pre>';
        echo $this->html;
    }
    
    

}

