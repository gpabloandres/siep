<?php
class Materia extends AppModel {
	var $name = 'Materia';
    public $displayField = 'alia';
    public $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasOne = array(
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'materia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $belongsTo = array(
	    'Curso' => array(
			'className' => 'Curso',
			'foreignKey' => 'curso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DisenoCurricular' => array(
			'className' => 'DisenoCurricular',
			'foreignKey' => 'disenocurricular_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Nota' => array(
			'className' => 'Nota',
			'foreignKey' => 'materia_id',
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
		'Horario' => array(
			'className' => 'Horario',
			'foreignKey' => 'materia_id',
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
		'Inscripcion' => array(
			'className' => 'Inscripcion',
			'joinTable' => 'inscripcions_materias',
			'foreignKey' => 'materia_id',
			'associationForeignKey' => 'inscripcion_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Inasistencia' => array(
			'className' => 'Inasistencia',
			'joinTable' => 'inasistencias_materias',
			'foreignKey' => 'materia_id',
			'associationForeignKey' => 'inasistencia_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Correlativa' => array(
			'className' => 'Correlativa',
			'joinTable' => 'correlativas_materias',
			'foreignKey' => 'materia_id',
			'associationForeignKey' => 'correlativa_id',
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
                   'created' => array(
						   'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una fecha y hora.'
						   )
                   ),
									 'curso_id' => array(

				 					 'required' => array(
				 					'rule' => 'notBlank',
				 					'required' => 'create',
				 					 'message' => 'seleccionar un curso.'
				 				 ),
				 				 'numeric' => array(
				 					 'rule' => 'naturalNumber',
				 					 'message' => 'Indicar una opción correcta.'
				 				 )
				 					 ),

				   'nombre' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un nombre.'
												 ),
												 'alphaBet' => array(
				                 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
												 'message' => 'Indicar un nombre correcto (Sólo letras y espacios)'

				    )),
                   'alia' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un alia.'
                           ),
													 'alphaBet' => array(
					                 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
													 'message' => 'indicar un alias correcto (Sólo letras y espacios)'
												 ),
						   'isUnique' => array(
	                       'rule' => 'isUnique',
	                       'message' => 'Este alias de materia esta siendo usado.'
	                     )
                   ),
                   'campo_formacion' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un campo de formación.'
												 ),
												 'alphaBet' => array(
				                 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
												 'message' => 'Indicar un campo de formación correcto (Sólo letras y espacios)'

                   )),
                   'formato' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un formato.'
												 ),
												 'alphaBet' => array(
				                 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
												 'message' => 'Indicar un formato correcto (Sólo letras y espacios)'

                   )),
                   'dictado' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un dictado.'
												 ),
												 'alphaBet' => array(
												 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
												 'message' => 'indicar una opción correcta'
												 )
                   ),
                   'obligatoriedad' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar una obligatoriedad.'
												 ),
												 'alphaBet' => array(
												 'rule' => '/^[ .áÁéÉíÍóÓúÚa-zA-ZñÑ0-9]{5,}$/i',
												 'message' => 'Ingresar una opción correcta'
												 )
					),
                   'carga_horaria_en' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar una opción.'
												 ),
												 'alphaBet' => array(
												 'rule' => '/^[ .áÁéÉíÍóÓúÚa-zA-ZñÑ0-9]{5,}$/i',
												 'message' => 'Ingresar una opción correcta'
												 )
                   ),
				   'carga_horaria_semanal' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una carga horaria.'
						   ),
						   'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => false,
                           'message' => 'Indicar un número.'
                           )
                   ),
				   'duracion_en' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar una opción.'
												 ),
												 'alphaBet' => array(
												 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
												 'message' => 'Ingresar una opción correcta'
												 )
                   ),
                   'duracion' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una duración.'
                           ),

						   'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => false,
                           'message' => 'Indicar un número.'
                           )
                   ),
                   'escala_numerica' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar una opción.'
												 ),
												 'alphaBet' => array(
												 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
												 'message' => 'Ingresar una opción correcta'
												 )
                   ),
				   'nota_minima' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar una nota mínima.'
                           ),
						   'naturalNumber' => array(
                           'rule' => 'naturalNumber',
                           'allowEmpty' => false,
                           'message' => 'Indicar un número entero.'
                           )
                   ),
				   /*'contenido' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Adjuntar contenidos.'
                           )
				   ),
				   'curso_id' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
                           'message' => 'Indicar un curso.'
                           )
				   ),
				   'rule1' => array(
				           'rule'    => array(
				           'extension',array('pdf')),
				           'message' => 'Please upload pdf file only'
				   ),
                   'rule2' => array(
                           'rule' => array('fileSize', '<=', '1MB'),
                           'message' => 'File must be less than 1MB'
                   )*/
	        );
}
?>
