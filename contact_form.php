<?php 

function contact_form () {

    $provincias = array(1 => 'Zaragoza', 2 => 'Huesca', 35 => 'Teruel');
    $radio_data = array('Sí' => 'y', 'No' => 'n');
    $def = array(
        'definition' => array(
            'method' => 'POST',
            'action' => 'process.php',
            'filedsets' => true
        ),      
        'fields' => array(
            'fieldset' => array(
                'legend' => 'asdasd',
                'nombre2' => array(
                    'form_type' => 'input',
                    'type' => 'checkbox',
                    'name' => 'nombre2',
                    'id' => 'nombre2',
                    'label' => 'Nombre 2:',
                    'required' => true,
                    'validation_rules' => array(
                        'required' => true,
                    )
                ), 
                'nombre' => array(
                    'form_type' => 'input',
                    'type' => 'text',
                    'name' => 'nombre',
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
                    'form_type' => 'input',
                    'type' => 'email',
                    'id' => 'email_1',
                    'name' => 'email_1',
                    'label' => 'Introduce tu email:',
                    'placeholder' => 'mail@ejemplo.com',
                    'required' => true
                ),
                'subject' => array(
                    'form_type' => 'textarea',
                    'id' => 'subject',
                    'name' => 'subject',
                    'label' => 'Di lo que quieras:',
                    'required' => true
                ), 
                'name_form' => array(
                    'form_type' => 'hidden',
                    'id' => 'name_form',
                    'name' => 'name_form',
                    'value' => 'test1'
                ),
            ),
            'fieldset2' => array(
                'legend' => 'Y otro fieldset',
                'provincia' => array(
                    'form_type' => 'select',
                    'id' => 'provincia',
                    'name' => 'provincia',
                    'data' => $provincias
                ),
                'socio' => array(
                    'form_type' => 'radio',
                    'name' => 'socio',
                    'data' => $radio_data
                )
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
