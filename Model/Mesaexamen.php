<?php
App::uses('AppModel', 'Model');
/**
 * MesaExamen Model
 *
 * @property Ciclo $Ciclo
 * @property Titulacion $Titulacion
 * @property Materia $Materia
 * @property Alumno $Alumno
 */
class Mesaexamen extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		           'created' => array(
						   'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una fecha y hora.'
						   )
                   ),
				   'ciclo_id' => array(
						   'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar un ciclo.'
						   )
                   ),
                   'titulacion_id' => array(
                           'required' => array(
  						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una titulación.'
                           )
                   ),
                   'materia_id' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una materia.'
                           )
                   ),
                   'alumno_id' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un alumno.'
                           )
                   ),
				   'mesa_especial' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un opción.'
                           )
                   ),
				   'turno' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una opción.'
                           )
                   ),
				   'acta_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un nº de acta.'
                           ),
						   'numeric' => array(
                           'rule' => 'numeric',                          
                           'allowEmpty' => false,
                           'message' => 'Indicar un número.'
                           )
                   ),
				   'libro_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un nº de libro.'
                           ),
						   'numeric' => array(
                           'rule' => 'numeric',                          
                           'allowEmpty' => false,
                           'message' => 'Indicar un número.'
                           )
                   ),
				   'folio_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un nº de folio.'
                           ),
						   'numeric' => array(
                           'rule' => 'numeric',                          
                           'allowEmpty' => false,
                           'message' => 'Indicar un número.'
                           )
                   ),
				   'seccion' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una sección.'
                           )
                   ),
   				   'aula' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un aula.'
                           )
                   ),
				   'modalidad' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una modalidad.'
                           )
					),
				   'presidente' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un  presidente.'
                           )
                   ),
				   'vocal_uno' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un vocal.'
                           )
                   ),
				   'vocal_dos' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un vocal.'
                           )
                   )
		);

	
	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ciclo' => array(
			'className' => 'Ciclo',
			'foreignKey' => 'ciclo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Titulacion' => array(
			'className' => 'Titulacion',
			'foreignKey' => 'titulacion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Materia' => array(
			'className' => 'Materia',
			'foreignKey' => 'materia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	/*
  var $hasAndBelongsToMany = array(
		'Alumno' => array(
			'className' => 'Alumno',
			'joinTable' => 'alumnos_mesaexamens',
			'foreignKey' => 'alumno_id',
			'associationForeignKey' => 'mesaexamen_id',
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
  */
}
