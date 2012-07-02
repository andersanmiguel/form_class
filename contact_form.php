<?php 

function contact_form () {

    $provincias = array(1 => 'Zaragoza', 2 => 'Huesca', 35 => 'Teruel');
    $radio_data = array('Sí' => 'y', 'No' => 'n');
    $def = array(
        'definition' => array(
            'method' => 'POST',
            'action' => 'process.php',
            'fieldsets' => true
        ),      
        'fields' => array(
                'fieldset' => true,
                array(
                    'type' => 'checkbox',
                    'args' => array(
                        'required' => true
                    ),
                    'name' => 'nombre2',
                    'id' => 'nombre2',
                    'required' => true,
                    'validation_rules' => array(
                        'required' => true,
                    )
                ), 
                'nombre' => array(
                    'type' => 'input',
                    'name' => 'nombre',
                    'label' => array(
                        'text' => 'Yeyhh, first label',
                        'style' => 'display: block;'
                    ),
                    'id' => 'nombre',
                    'placeholder' => 'Nombre',
                    'required' => true,
                    'validation_rules' => array(
                        'required' => true,
                        'type' => 'string',
                        'args' => '5-12'
                    )
                ), 
                'email_1' => array(
                    'type' => 'input',
                    'id' => 'email_1',
                    'name' => 'email_1',
                    'placeholder' => 'mail@ejemplo.com',
                    'required' => true
                ),
                'subject' => array(
                    'type' => 'textarea',
                    'id' => 'subject',
                    'name' => 'subject',
                    'required' => true
                ), 
                'name_form' => array(
                    'type' => 'input',
                    'id' => 'name_form',
                    'name' => 'name_form',
                    'value' => 'test1'
                ),
        ),
        'submit' => array(
            'form_type' => 'input',
            'type' => 'submit',
            'label' => '',
            'id' => 'submit'
        )
    );
    // $def = '';


    return $def;

}

function second_form() {

    $def = array(
        'definition' => array(
            'method' => 'POST',
            'action' => 'process.php',
        ),
        'fields' => array(
            'subject' => array(
                'form_type' => 'textarea',
                'id' => 'subject',
                'name' => 'subject',
                'label' => 'Di lo que quieras:',
                'required' => true,
                'validation_rules' => array(
                    'required' => true,
                    'type' => 'string',
                    'args' => '5-12'
                )
            ) 
        ),
        'submit' => array(
            'form_type' => 'input',
            'type' => 'submit',
            'label' => '',
            'id' => 'submit'
        )
    );

    return $def;
}
