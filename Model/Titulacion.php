<?php
class Titulacion extends AppModel {
	var $name = 'Titulacion';
  public $displayField = 'nombre';
	public $actsAs = array('Containable');

  //The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
	'DisenoCurriculars' => array(
      'className' => 'DisenoCurriculars',
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
                'valid' => array(
					'rule' => array('inList', array('Primaria de 6 años', 'Primaria de 7 años', '9 años', 'Secundaria', 'EGB - Primaria y Ciclo Básico', 'Sin requisitos', 'Medio completo', 'Otros')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
					'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
					'message' => 'Indicar una opción correcta'
				)
            ),
			'condicion_ingreso' => array(
                'valid' => array(
					'rule' => array('inList', array('Asistir al Curso', 'Aprobar Curso', 'Examen de Ingreso', 'Prueba de nivel o aptitud', 'Sin requisitos- unicamente Primario', 'Sin  requisitos - unicamente Secundario', 'Otros' => 'Otros')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
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
			'tipo_formacion' => array(
				'valid' => array(
					'rule' => array('inList', array('Docente', 'Docente y Técnico Profesional', 'Técnico tecnológico', 'Técnico humanístico')),
					'allowEmpty' => true,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
					'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
					'message' => 'Indicar una opción correcta'
				)
			),
			'tipo' => array(
				'valid' => array(
					'rule' => array('inList', array('Grado-Formación Inicial', 'Posgrado-Especialización', 'Postítulo Docente')),
					'allowEmpty' => true,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
					'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
					'message' => 'Indicar una opción correcta'
				)
			),
			'a_termino' => array(
               'boolean' => array(
               		'rule' => array('boolean'),
					'message' => 'Indicar una opción'
				)
            ),
			'orientacion' => array(
                'valid' => array(
					'rule' => array('inList', array('Bachiller', 'Ciclo Básico', 'Comercial', 'Técnica', 'Agropecuaria', 'Artística', 'Otros', 'Ciclo Básico Técnico', 'Humanidades y Cs. Sociales', 'Ciencias Naturales', 'Economía y Gestión de las Organizaciones', 'Producción de Bienes y Servicios', 'Comuncación, Artes y Diseño', 'Ciclo Básico Artístico', 'Ciclo Básico Agrario', 'Lenguas', 'Economía y Administración', 'Informática', 'Agro y Ambiente', 'Turismo', 'Comunicación', 'Educación Física', 'Ciencias naturales,salud y medio ambiente', 'Gestión y Administración', 'Tecnología', 'Letras', 'Físico Matemática', 'Pedagogía')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
				    'rule' => '/^[ .,áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
					'message' => 'Indicar una opción correcta'
				)
            ),
			'organizacion_plan' => array(
                'valid' => array(
					'rule' => array('inList', array('Año de estudio', 'Grado', 'Módulo', 'Ciclo', 'Etapa', 'Trayecto formativo', 'Trayecto formativo y año')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
			    	'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
					'message' => 'Indicar una opción correcta'
				)
            ),
			'organizacion_cursada' => array(
                'valid' => array(
					'rule' => array('inList', array('Sección', 'Comisión', 'División', 'Espacio Curricular', 'Caso especial')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
					'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
					'message' => 'Indicar una opción correcta'
				)
            ),
			'forma_dictado' => array(
                'valid' => array(
					'rule' => array('inList', array('Presencial', 'A Distancia - Semipresencial', 'A Distancia - Asistida', 'A Distancia - Abierta', 'A Distancia - Virtual')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
					'rule' => '/^[ -áÁéÉíÍóÓúÚa-zA-ZñÑ]{5,}$/i',
					'message' => 'Indicar una opción correcta'
			    )
            ),
			'carga_horaria_en' => array(
                'valid' => array(
					'rule' => array('inList', array('Hora Cátedra', 'Hora Reloj')),
					'allowEmpty' => true,
					'message' => 'Indicar una opción'
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
                'valid' => array(
					'rule' => array('inList', array('Si', 'No Articula', 'Si, en este establecimiento', 'Si, en otro establecimiento')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
					'rule' => '/^[ ,áÁéÉíÍóÓúÚa-zA-ZñÑ]{2,}$/i',
					'message' => 'Indicar una opción correcta'
				)
            ),
			'duracion_en' => array(
                'valid' => array(
					'rule' => array('inList', array('Años', 'Cuatrimestres')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
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
                'valid' => array(
					'rule' => array('inList', array('Ley', 'Resolución')),
					'allowEmpty' => false,
					'message' => 'Indicar una opción'
				),
				'alphaBet' => array(
				 	'rule' => '/^[ áÁéÉíÍóÓúÚa-zA-ZñÑ]{3,}$/i',
				 	'message' => 'Indicar una opción correcta'
				)
			),
            'norma_aprob_jur_nro' => array(
                'alphaNumeric' => array(
                    'rule' => 'alphaNumeric',
                    'allowEmpty' => false,
				    'message' => 'Indicar con letras y números.'
				)
            ),
			'norma_aprob_jur_anio' => array(
                'numeric' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => 'Indicar un año.'
				)
            ),
			'norma_val_nac_tipo' => array(
				'valid' => array(
					'rule' => array('inList', array('Ley', 'Resolución')),
					'allowEmpty' => true,
					'message' => 'Indicar una opción'
				),
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
				'valid' => array(
					'rule' => array('inList', array('Ley', 'Resolución')),
					'allowEmpty' => true,
					'message' => 'Indicar una opción'
				),
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
				'valid' => array(
					'rule' => array('inList', array('Ley', 'Resolución')),
					'allowEmpty' => true,
					'message' => 'Indicar una opción'
				),
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
