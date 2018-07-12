<?php
class Titulo extends AppModel {
	var $name = 'Titulo';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Docente' => array(
			'className' => 'Docente',
			'foreignKey' => 'docente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

//Validaciones

        var $validate = array(
                   'titulo' => array(
                           'minLength' => array(
                           'rule' => array('minLength',5),
                           'allowEmpty' => false,
                           'message' => 'Indicar una opcion.'
                           )
                    ),
                   'tipo' => array(
                           'minLength' => array(
                           'rule' => array('minLength',5),
                           'allowEmpty' => false,
                           'message' => 'Indicar una opcion.'
                           )
                    ),
                   'institucion' => array(
                           'minLength' => array(
                           'rule' => array('minLength',5),
                           'allowEmpty' => false,
                           'message' => 'Indicar la institucion dadora del titulo.'
                           )
                   ),

        );

}
?>
