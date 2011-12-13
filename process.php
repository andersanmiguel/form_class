<?php 

include 'validator.php';
include 'contact_form.php';
include 'hform.php';

$values = $_POST;

$form_array = contact_form();
$form = new Hform($form_array);
$fields = $form->get_fields();

$valid = new Validator($fields, $values);

if(is_array($valid->veredict())) {
    header('Location: index.php?errores='.serialize($valid->veredict()).'&values='.serialize($values));
} else {
    $message = 'Mission accomplished.';
    header('Location: index.php?message='.$message);
}




