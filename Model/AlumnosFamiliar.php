<?php
App::uses('AppModel', 'Model');
/**
 * CursosInscripcion Model
 *
 * @property Curso $Curso
 * @property Inscripcion $Inscripcion
 */
class AlumnosFamiliar extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	var $name = 'AlumnosFamiliar';
	//public $virtualFields = array('matricula'=> 'CONCAT(CursosInscripcion.curso_id, " ", CursosInscripcion.inscripcion_id)');	


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Alumno' => array(
			'className' => 'Alumno',
			'foreignKey' => 'alumno_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Familiar' => array(
			'className' => 'Familiar',
			'foreignKey' => 'familiar_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
