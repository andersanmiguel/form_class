<?php 

include 'validator.php';
include 'contact_form.php';

$form_array = contact_form();

if(isset($form_array['definition'])) {
    unset($form_array['definition']);
}
if(isset($form_array['submit'])) {
    unset($form_array['submit']);
} 
foreach($form_array['fields'] as $fieldset) {
    foreach($fieldset as $id => $field) {
        if(is_array($field)) {
            $fields[$id] = $field;
        }
    }
}
$values = $_POST;

$valid = new Validator($fields, $values);




