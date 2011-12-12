<?php 

class Hform {

    /* ToDo: 
        - Selected with value
        - error display?? 
          * Maybe <span class="error"> On __construct() or form()...
        - Quitar los required del markup
    */

    protected $html;

    function __construct($form_array, $values = array()) {
        
        // Extraer la definicion del formulario y los botones de acción
        
        if($form_array == '') {
            return false;
        }
        if(isset($form_array['definition'])) {
            $definition = $form_array['definition'];
            unset($form_array['definition']);
        } else {
            return false;
        }
        if(isset($form_array['submit'])) {
            $submit = $form_array['submit'];
            unset($form_array['submit']);
        } else {
            return false;
        }

        $html = '';

        $html .= $this->open_form($definition);

        $num_fieldset = count($form_array['fields']);
        foreach($form_array['fields'] as $fieldset) {
            if($num_fieldset > 1) {
                $html .= '<fieldset>';
                if(isset($fieldset['legend'])) {
                    $html .= '<legend>'.$fieldset['legend'].'</legend>';
                    unset($fieldset['legend']);
                }
            }
            foreach($fieldset as $field) {
                if(isset($field['validation_rules'])) {
                    unset($field['validation_rules']);
                }
                if(!empty($values) && is_array($values)){
                    if(isset($values[$field['name']])) {
                        $value = $values[$field['name']];
                    } else {
                        $value = '';
                    }
                } else {
                    $value = '';
                }

                if($field['form_type'] == 'radio') { $html .= '<p>'; }
                $html .= $this->$field['form_type']($field, $value, 'before', 'p')."\n";
                if($field['form_type'] == 'radio') { $html .= '</p>'; }
            }
            if($num_fieldset > 1) {
                $html .= '</fieldset>';
            }
        }
        $html .= $this->$submit['form_type']($submit, '', 'before', 'p')."\n";

        $html .= $this->close_form();

        $this->html = $html;
        return $this->html;
    } 

    public function open_form($desc) {

        // <form method="POST/GET" action="" id="" class=""...>
        $html = '';
        $args = '';

        if(!isset($desc['method'])) {
            $metod = 'POST';
        } else {
            $metod = $desc['method'];
            unset($desc['method']);
        }

        if(is_array($desc)) {
            foreach($desc as $attr => $val) {
                $args .= " $attr=\"$val\" ";
            }
        }


        $html .= '<form method="'.$metod.'" '.$args.' >';

        return $html;

    }

    public function close_form() {
        return '</form>';
    }

    public function input($desc, $value = '', $label_position = 'before', $wrap = '') {

        $args = '';    
        $label = '';    
        unset($desc['form_type']);
        if(isset($desc['required'])) {
            unset($desc['required']);
        }

        if(!is_array($desc)) {
            $args .= 'type="text" id="'.$desc.'" name="'.$desc.'"';
            $label .= '<label for="'.$desc.'">'.ucfirst($desc).'</label>';
        } else {
            
            if(!isset($desc['name']) && isset($desc['id'])) {
                $desc['name'] = $desc['id'];
            }
            if(!isset($desc['type'])) {
                $desc['type'] = 'text';
            }

            if(isset($desc['label'])) {
                $label .= '<label for="'.$desc['id'].'">'.$desc['label'].'</label>';
                unset($desc['label']);
            } else {
                $label .= '<label for="'.$desc['id'].'">'.ucfirst($desc['id']).':</label>';
            }

            foreach($desc as $attr => $val) {
                $args .= $attr.'="'.$val.'" ';
            }

        }

        if($value != '') {
            $args .= 'value="'.$value.'" ';
        }

        $html = '';
        if($label_position == 'before') {
            $html .= $label.' ';
        }
        $html .= "<input $args />";
        if($label_position == 'after') {
            $html .= ' '.$label;
        }

        if($wrap != '') {
            $html = "<$wrap>$html</$wrap>";
        }

        return $html;
    }

    public function hidden($desc, $value='') {
        $html = '';
        unset($desc['form_type']);

        if(!isset($desc['name']) && isset($desc['id'])) {
            $desc['name'] = $desc['id'];
        }

        if($value != '') {
            $desc['value'] = $value;
        } 

        $html .= '<input type="hidden" id="'.$desc['id'].'" name="'.$desc['name'].'" value="'.$desc['value'].'" />';

        return $html;
    }

    public function select($desc, $value='', $label_position = 'before') {
        
        $html = '';

        unset($desc['form_type']);

        if(!isset($desc['name']) && isset($desc['id'])) {
            $desc['name'] = $desc['id'];
        }

        if(isset($desc['label'])) {
            $label .= '<label for="'.$desc['id'].'">'.$desc['label'].'</label>';
            unset($desc['label']);
        } else {
            $label .= '<label for="'.$desc['id'].'">'.ucfirst($desc['id']).':</label>';
        }

        foreach($desc as $attr => $val) {
            if(!is_array($val)) {
                $args .= $attr.'="'.$val.'" ';
            }
        }

        if($label_position == 'before') {
            $html .= $label.' ';
        }

        $html .= "<select $args >";

        if(isset($desc['data'])) {
            if(is_array($desc['data'])) {
                foreach($desc['data'] as $id => $val) {
                    $selected = $value == $id ? ' selected="selected"' : '';
                    $html .= '<option value="'.$id.'"'.$selected.'>'.$val.'</option>';
                }
            } else {
                $selected = $value == $desc['data'] ? ' selected="selected"' : '';
                $html .= '<option value="'.$desc['data'].'"'.$selected.'>'.$desc['data'].'</option>';
            }
        }

        $html .= '</select>';

        if($label_position == 'after') {
            $html .= ' '.$label;
        }

        return $html;
    
    }

    public function textarea($desc, $value = '', $label_position = 'before', $wrap = '') {

        $args = '';    
        $label = '';    
        unset($desc['form_type']);
        if(isset($desc['required'])) {
            unset($desc['required']);
        }

        if(!is_array($desc)) {
            $args .= 'id="'.$desc.'" name="'.$desc.'"';
            $label .= '<label for="'.$desc.'">'.ucfirst($desc).'</label>';
        } else {
            
            if(!isset($desc['name']) && isset($desc['id'])) {
                $desc['name'] = $desc['id'];
            }

            if(!isset($desc['label'])) {
                $label .= '<label for="'.$desc['id'].'">'.ucfirst($desc['id']).':</label>';
            } else {
                $label .= '<label for="'.$desc['id'].'">'.$desc['label'].'</label>';
                unset($desc['label']);
            }

            foreach($desc as $attr => $val) {
                $args .= $attr.'="'.$val.'" ';
            }

        }

        if($value != '') {
            $text = $value;
        } else {
            $text = '';
        }

        $html = '';
        if($label_position == 'before') {
            $html .= $label.' ';
        }
        $html .= "<textarea $args>$text</textarea>";
        if($label_position == 'after') {
            $html .= ' '.$label;
        }

        if($wrap != '') {
            $html = "<$wrap>$html</$wrap>";
        }

        return $html;
    }

    public function radio($desc, $value = '', $label_position = 'before', $wrap = '') {
        // <input type="radio" name="name" id="id" class="" ... />

        $html = '';
        $desc['type'] = $desc['form_type'];
        unset($desc['form_type']);

        if(!isset($desc['name']) && isset($desc['id'])) {
            $desc['name'] = $desc['id'];
        }

        foreach($desc as $attr => $val) {
            if(!is_array($val)) {
                $args .= $attr.'="'.$val.'" ';
            }
        }

        if($label_position == 'before') {
            $html .= $label.' ';
        }

        if(is_array($desc['data'])) {
            foreach($desc['data'] as $id => $val) {
                if($value != '' && $value == $val) {
                    $extra = ' checked="checked" ';
                } else {
                    $extra = '';
                }
                $html .= $id.": <input value=\"$val\" $args $extra />";
            }
        }

        if($label_position == 'after') {
            $html .= $label.' ';
        }

        return $html;


    }

    public function render() {
        echo $this->html;
    }

}