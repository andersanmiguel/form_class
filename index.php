<?php 
// Call to class and so
error_reporting(-1);


include 'hform.php';
include 'contact_form.php';
$form_array = contact_form();
$values = array('email_1' => 'a@a.c', 'socio' => 'n', 'subject' => 'asdasdasd asdokjasd ', 'provincia' => 2);
$values = array();
$errors = array();
$values = isset($_GET['values']) ? unserialize(urldecode($_GET['values'])) : array();


$message = isset($_GET['message']) ? $_GET['message'] : 'Demo - formulario';

if(isset($_GET['errores'])) {
    $errors = unserialize(urldecode($_GET['errores']));
} 



$form = new Hform($form_array, $values, $errors);

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
        span.error { color: #F97575; font-size: .8em; }
    </style>
</head>
<body>
    
    <h2 style="border: 1px solid #ddd; background: #eee; font-family: 'League Gothic', sans-serif; padding: .3em; font-size: 1.8em; text-transform: uppercase; color: #666; padding-left: 3em;"><?php echo $message; ?></h2>

    <h5>Live Test form</h5>
    <?php echo $form->render(); ?>

</body>
</html>
