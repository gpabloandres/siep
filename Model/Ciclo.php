<?php
App::uses('AppModel', 'Model');

class Ciclo extends AppModel {
	var $name = 'Ciclo';
    var $displayField = 'nombre';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Inscripcion' => array(
			'className' => 'Inscripcion',
			'foreignKey' => 'ciclo_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Nota' => array(
			'className' => 'Nota',
			'foreignKey' => 'ciclo_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Integracion' => array(
			'className' => 'Integracion',
			'foreignKey' => 'ciclo_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Servicio' => array(
			'className' => 'Servicio',
			'foreignKey' => 'ciclo_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Inasistencia' => array(
			'className' => 'Inasistencia',
			'foreignKey' => 'ciclo_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Pase' => array(
			'className' => 'Pase',
			'foreignKey' => 'ciclo_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
    );

	var $hasAndBelongsToMany = array(
		'Cargo' => array(
			'className' => 'Cargo',
			'joinTable' => 'cargos_ciclos',
			'foreignKey' => 'ciclo_id',
			'associationForeignKey' => 'cargo_id',
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
				   /*
				   'created' => array(
                         'required' => array(
						 'rule' => 'notBlank',
                         'required' => 'create',
						 'message' => 'Indicar una fecha y hora.'
                         )
                   ),
                   */
				   'nombre' => array(
                         'required' => array(
						 'rule' => 'notBlank',
                         'required' => 'create',
                         'message' => 'Indicar un nombre.'
                         ),
						 'isUnique' => array(
						 'rule' => 'isUnique',
						 'message' => 'Este nombre de ciclo esta siendo usado.'
					 ),
					 'numeric' => array(
						 'rule' => 'naturalNumber',
						 'message' => 'Indicar número sin puntos ni comas ni espacios.'
					 )
                   ),
                   'fechaInicio' => array(
                         'required' => array(
						 						 'rule' => 'date',
                         'required' => 'create',
                         'message' => 'Indicar una fecha.'
	                     )
                   ),
                   'fechaFinal' => array(
                         'required' => array(
						 						 'rule' => 'date',
                         'required' => 'create',
                         'message' => 'Indicar una fecha.'
	                     )
                   )
                   /*
                   'primer_periodo' => array(
                         'required' => array(
						 'rule' => 'notBlank',
                         'required' => 'create',
                         'message' => 'Indicar una fecha.'
	                     )
                   ),
                   'segundo_periodo' => array(
                         'required' => array(
						 'rule' => 'notBlank',
                         'required' => 'create',
                         'message' => 'Indicar una fecha.'
	                     )
                   ),
				   'tercer_periodo' => array(
                         'required' => array(
						 'rule' => 'notBlank',
                         'required' => 'create',
                         'message' => 'Indicar una fecha.'
	                     )
                   ),
                   */
          );
}
?>
