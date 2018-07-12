<?php
class Familiar extends AppModel {
	var $name = 'Familiar';
  //var $displayField = 'apellido';
	//public $virtualFields = array('nombre_completo_familiar'=> 'CONCAT(Familiar.primerNombre, " ", Familiar.apellido)');
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
  var $belongsTo = array(
		'Persona' => array(
			'className' => 'Persona',
			'foreignKey' => 'persona_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	   
  var $hasAndBelongsToMany = array(
    'Alumno' => array(
      'className' => 'Alumno',
      'joinTable' => 'alumnos_familiars',
      'foreignKey' => 'familiar_id',
      'associationForeignKey' => 'alumno_id',
      'unique' => true,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'finderQuery' => '',
      'deleteQuery' => '',
      'insertQuery' => ''
    )
  );

  //Validaciones
  var $validate = array(
    'vinculo' => array(
      'minLength' => array(
      'rule' => array('minLength',5),                          
      'allowEmpty' => false,
      'message' => 'Indicar una de las opciones de la lista.'
      )
    ),
    'conviviente' => array(
      'boolean' => array(
      'rule' => array('boolean'),
      'allowEmpty' => true,
      'message' => 'Indicar una opción'
      )
    ),
    'autorizado_retirar' => array(
      'boolean' => array(
      'rule' => array('boolean'),
      'allowEmpty' => true,
      'message' => 'Indicar una opción'
      )
    )
	);
}
?>
