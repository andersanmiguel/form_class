<?php 
// Call to class and so
error_reporting(-1);

// Load the hform class
include 'forms.php';

// Load the form
include 'contact_form.php';
$form_array = contact_form();
// $form_array = second_form();

$values = array();
$errors = array();

// Recovery previous values|errors
$values = isset($_GET['values']) ? unserialize(urldecode($_GET['values'])) : array();
$message = isset($_GET['message']) ? $_GET['message'] : 'Demo - formulario';
if(isset($_GET['errores'])) {
    $errors = unserialize(urldecode($_GET['errores']));
} 

$errors['input'] = 'Error en el campo input';

// Set the form
$form = new Forms($form_array, $values, $errors);
$form->show_errors = true;

// Alternative syntax to set the form
// $form = new Hform();
// $form->set_form($form_array);
// $form->set_values($values);
// $form->set_errors($errors);

  
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Demo Form Helper Class</title>
    <style>
        body { font-size: 1em; font-family: "Open Sans", Verdana, sans-serif; }
        span.error { color: #F97575; font-size: .8em; }
        h2 { border: 1px solid #ddd; background: #eee; font-family: 'League Gothic', sans-serif; padding: .3em; font-size: 1.8em; text-transform: uppercase; color: #666; padding-left: 3em; }
    </style>
</head>
<body>
    
    <h2 style=""><?php echo $message; ?></h2>

    <h5>Live Test form</h5>
    <?php // Show the form, if $values then show them, if $errors then span them and show them ?>
    <?php echo $form->label('input', 'Text label'); ?>
    <?php echo $form->input('input', 'required'); ?>
    <?php echo $form->checkbox('checkbox', array('h', 'g'), 'required'); ?>
    <?php echo $form->select('select', array('s' => 'h', 'g'), 'required'); ?>
    <?php echo $form->textarea('textarea', array('required', 'cols' => 50, 'rows' => 10)); ?>
    <?php echo $form->render(); ?>

</body>
</html>
