<?php 

include 'validator.php';
include 'contact_form.php';
include 'hform.php';

$values = $_POST;

$form_array = contact_form();
$form_array = second_form();
$form = new Hform($form_array);
$fields = $form->get_fields();

$valid = new Validator($fields, $values);

if(is_array($valid->fail_validator())) {
    header('Location: index.php?errores='.urlencode(serialize($valid->fail_validator())).'&values='.urlencode(serialize($values)));
    // echo '<pre>';
    // print_r($valid->fail_validator());
    // echo '</pre>';
    // die;
} else {
    $message = 'Mission accomplished.';
    header('Location: index.php?message='.$message);
}




