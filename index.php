<?php 
// Call to class and so

include 'hform.php';
include 'contact_form.php';

$form_array = contact_form();
$values = array('email_1' => 'a@a.c', 'socio' => 'n', 'subject' => 'asdasdasd asdokjasd ', 'provincia' => 2);

$form = new Hform($form_array, $values);

  
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Demo Form Helper Class</title>
</head>
<body>

    <h5>Live Test form</h5>
    <?php echo $form->render(); ?>

</body>
</html>
