<?php 

function contact_form () {

    $provincias = array('Zaragoza' => '35', 'Huesca' => 'as', 'Teruel' => 'ad');
    $radio_data = array('Sí' => 'y', 'No' => 'n');
    $def = array(
        'definition' => array(
            'method' => 'POST',
            'action' => 'process.php',
            'tag' => 'p',
        ),      
        'fields' => array(
                'fieldset' => true,
                'legend' => 'Un formulario, sin más',
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
                array(
                    'type' => 'select',
                    'name' => 'nombre',
                    'label' => array(
                        'text' => 'Yeyhh, first label',
                        'style' => 'display: block;',
                    ),
                    'args' => array(
                        'values' => $provincias,
                    ),
                    'required' => true,
                ), 
                array(
                    'type' => 'input',
                    'id' => 'email_1',
                    'name' => 'email_1',
                    'args' => array(
                        'placeholder' => 'mail@ejemplo.com',
                    ),
                    'validation_rules' => array(
                        'required' => true,
                        'type' => 'email'
                    )
                ),
                array(
                    'type' => 'textarea',
                    'id' => 'subject',
                    'name' => 'subject',
                    'required' => true,
                    'validation_rules' => array(
                        'required' => true,
                        'type' => 'string',
                        'args' => '2-12'
                    )
                ), 
                array(
                    'type' => 'input',
                    'id' => 'name_form',
                    'name' => 'name_form',
                    'value' => 'test1'
                ),
                array(
                    'type' => 'submit',
                    'name' => 'Enviar',
                )
        ),
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
            'value' => '',
            'id' => 'submit'
        )
    );

    return $def;
}
