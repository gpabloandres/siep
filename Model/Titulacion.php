<?php
class Titulacion extends AppModel {
	var $name = 'Titulacion';
  public $displayField = 'nombre';
	public $actsAs = array('Containable');

  //The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Disenocurricular' => array(
      'className' => 'Disenocurricular',
      'foreignKey' => 'titulacion_id',
      'conditions' => '',
      'fields' => '',
      'order' => ''
    ),
    'Curso' => array(
			'className' => 'Curso',
			'foreignKey' => 'titulacion_id',
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
  );

  var $hasAndBelongsToMany = array(
    'Centro' => array(
      'className' => 'Centro',
      'joinTable' => 'centros_titulacions',
      'foreignKey' => 'titulacion_id',
      'associationForeignKey' => 'centro_id',
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
			'nombre' => array(
                'required' => array(
				'rule' => 'notBlank',
				'required' => 'create',
                'message' => 'Indicar una opcion.'
                ),
				'isUnique' => array(
	            'rule' => 'isUnique',
	            'message' => 'Este nombre esta siendo usado.'
	            ),
				'alphaBet' => array(
				'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
				'message' => 'Indicar el nombre de la titulación (Sólo letras y espacios)'
				)
            ),
            'certificacion' => array(
                'required' => array(
				'rule' => 'notBlank',
				'required' => 'create',
               'message' => 'Indicar la certificación.'
						 ),
						 'alphaBet' => array(
						 'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
						 'message' => 'Indicar una opción correcta'
					 )
               ),
				    'condicion_ingreso' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
               'message' => 'Indicar la condición de ingreso.'
						 ),
						 'alphaBet' => array(
						 'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
						 'message' => 'Indicar una opción correcta'
					 )
               ),
				   'ciclo_implementacion' => array(
               'required' => array(
							'rule' => 'notBlank',
							 'required' => 'create',
               'message' => 'Indicar el ciclo de implementación.'
						 ),
						 'numeric' => array(
	 						'rule' => 'naturalNumber',
	 						'message' => 'Indicar número sin puntos ni comas ni espacios.'
	 					)
               ),
							 'ciclo_finalizacion' => array(
		               'required' => array(
									 'allowEmpty' => true,
								     'message' => 'Indicar el ciclo de finalización.'
								 ),
								 'numeric' => array(
			 						'rule' => 'naturalNumber',
			 						'message' => 'Indicar número sin puntos ni comas ni espacios.'
			 					)
		               ),
				   'a_termino' => array(
               'boolean' => array(
               'rule' => array('boolean'),
					     'message' => 'Indicar una opción'
				               )
                ),

								'tipo' => array(
										'required' => array(
										'allowEmpty' => true,
										'required' => 'create',
										'message' => 'Indicar una opcion correcta.'
									),
									'alphaBet' => array(
									'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
									'message' => 'Indicar una opción correcta'
								)
								),
				   'orientacion' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
               'message' => 'Indicar una opción.'
						 ),
						 'alphaBet' => array(
						 'rule' => '/^[ .,áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
						 'message' => 'Indicar una opción correcta'
					 )
                ),
				   'organizacion_plan' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
               'message' => 'Indicar una opción.'
						 ),
						 'alphaBet' => array(
						 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
						 'message' => 'Indicar una opción correcta'
					 )
                ),
				   'organizacion_cursada' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
               'message' => 'Indicar una opción.'
						 ),
						 'alphaBet' => array(
						 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
						 'message' => 'Indicar una opción correcta'
					 )
                ),
				   'forma_dictado' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
               'message' => 'Indicar una opción.'
						 ),
						 'alphaBet' => array(
						 'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
						 'message' => 'Indicar una opción correcta'
					 )
                ),
				   'carga_horaria_en' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
               'message' => 'Indicar una opción.'
						 ),
						 'alphaBet' => array(
						'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
						'message' => 'Indicar una opción correcta'
					)
                ),
				   'carga_horaria' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una carga horaria.'
						 ),
						 'numeric' => array(
							 'rule' => 'naturalNumber',
							 'message' => 'Indicar número sin puntos ni comas ni espacios.'
						 )
                ),
				   'edad_minima' => array(
               'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una edad.'
                           ),
						   'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => false,
                           'message' => 'Indicar un número.'
                           )
                   ),
				   'tiene_articulacion' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una articulación.'
						 ),
						 'alphaBet' => array(
					 'rule' => '/^[ ,áÁéÉíÍóÓúÚa-zA-ZñÑ]{2,}$/i',
					 'message' => 'Indicar una opción correcta'
				 )
                   ),
				   'duracion_en' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una opción.'
						 ),
						 'alphaBet' => array(
					'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{4,}$/i',
					'message' => 'Indicar una opción correcta'
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
				   'norma_aprob_jur_tipo' => array(
                           'required' => array(
						   'rule' => 'notBlank',
						   'required' => 'create',
						   'message' => 'Indicar una opción.'
						 ),
						 'alphaBet' => array(
				 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{3,}$/i',
				 'message' => 'Indicar una opción correcta'
					 )
				   ),
                  'norma_aprob_jur_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_aprob_jur_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => true,
                           'message' => 'Indicar un año.'
												 )
                   ),
				   'norma_val_nac_tipo' => array(

												 'alphaBet' => array(
										 'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{2,}$/i',
										 'allowEmpty' => true,
										 'message' => 'Indicar una opción correcta'
											 )
                   ),
				   'norma_val_nac_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_val_nac_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => true,
                           'message' => 'Indicar un año.'
                           )
                   ),
				   'norma_ratif_jur_tipo' => array(
						 				'alphaBet' => array(
										'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{2,}$/i',
										'allowEmpty' => true,
										'message' => 'Indicar una opción correcta'
					)
                   ),
				   'norma_ratif_jur_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_ratif_jur_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => true,
                           'message' => 'Indicar un año.'
                           )
                   ),
				   'norma_homologacion_tipo' => array(
						 						'alphaBet' => array(
				 								'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{2,}$/i',
				 							'allowEmpty' => true,
				 						'message' => 'Indicar una opción correcta'
					 					)
                   ),
				   'norma_homologacion_nro' => array(
                           'alphaNumeric' => array(
                           'rule' => 'alphaNumeric',
                           'allowEmpty' => true,
						   'message' => 'Indicar con letras y números.'
						   )
                   ),
				   'norma_homologacion_anio' => array(
                           'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => true,
                           'message' => 'Indicar un año.'
                           )
                   )
		);
}
?>
