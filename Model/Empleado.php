<?php
App::uses('AppModel', 'Model');

class Empleado extends AppModel {
	
	var $name = 'Empleado';
    //var $displayField = 'apellido';
	public $virtualFields = array('nombre_completo_empleado'=>'CONCAT(Empleado.nombres, " ", Empleado.apellidos)');
	/*
	public $actsAs = array(
			'Upload.Upload' => array(
				'foto' => array(
					'fields' => array(
						'dir' => 'foto_dir'
					),
					'thumbnailMethod' => 'php',
					'thumbnailSizes' => array(
						'vga' => '640x480',
						'thumb' => '150x150'
					),
					'deleteOnUpdate' => true,
					'deleteFolderOnDelete' => true
				)
			)
		);
    */
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Licencia' => array(
			'className' => 'Licencia',
			'foreignKey' => 'empleado_id',
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
		'Inventario' => array(
			'className' => 'Inventario',
			'foreignKey' => 'empleado_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'empleado_id',
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
			'foreignKey' => 'empleado_id',
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
		'Cargo' => array(
			'className' => 'Cargo',
			'joinTable' => 'cargos_empleados',
			'foreignKey' => 'empleado_id',
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
		),
		'Centro' => array(
			'className' => 'Centro',
			'joinTable' => 'centros_empleados',
			'foreignKey' => 'empleado_id',
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
				   'nombres' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un nombre completo.'

                           )
                   ),
                   'apellidos' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar los apellidos.'
                           )
                   ),
				   'sexo' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar sexo.'
                           )
                   ),
				   'documento_tipo' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un tipo de documento.'
                           )
                   ),
                   'documento_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar un nº de documento.'
						   ),
						   'numeric' => array(
                           'rule' => 'numeric',
                           'message' => 'Indicar un número sin puntos ni espacios.'
                           ),
						   'isUnique' => array(
	                       'rule' => 'isUnique',
	                       'message' => 'Este documento de empleado esta siendo usado.'
	                       )
                   ),
                   'fecha_nac' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una fecha de nacimiento.'
                           )
                   ),
				   'pcia_nac' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una provincia.'
                           )
                   ),
				   /*'indigena' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una comunidad indígena.'
                           )
                   ),*/
				  'estado_civil' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un estado civil.'
                           )
                   ), 
				   'telefono_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un teléfono.'
                           )
                   ),
                   'email' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar un Email.'
						   ),
						   'email' => array(
                           'rule' => 'email',
                           'allowEmpty' => true,
                           'message' => 'Indicar un formato válido.'
                           )
                   ),
                   'calle_nombre' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar un nombre de calle.'
                           )
                   ),
				   'calle_nro' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar un nº de calle.'
						   ),
						   'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => false,
                           'message' => 'Indicar un nº.'
                           )
					),
					'barrio' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
						   'message' => 'Indicar un barrio.'
                           )
                   ),	   
                    'ciudad' => array(
                           'required' => array(
						   'rule' => 'notBlank',
                           'required' => 'create',
                           'message' => 'Indicar una ciudad.'                           )
                   ),
		   		   /*
		   		   'foto' => array(
					  'uploadError' => array(
						  'rule' => 'uploadError',
						  'message' => 'Algo anda mal, intente nuevamente',
						  'on' => 'create'
					  ),
					  'isUnderPhpSizeLimit' => array(
						  'rule' => 'isUnderPhpSizeLimit',
						  'message' => 'Archivo excede el límite de tamaño de archivo de subida'
					  ),
					  'isValidMimeType' => array(
						  'rule' => array('isValidMimeType', array('image/jpeg', 'image/png'), false),
						  'message' => 'La imagen no es jpg ni png',
					  ),
					  'isBelowMaxSize' => array(
						  'rule' => array('isBelowMaxSize', 1048576),
						  'message' => 'El tamaño de imagen es demasiado grande'
					  ),
					  'isValidExtension' => array(
						  'rule' => array('isValidExtension', array('jpg', 'png'), false),
						  'message' => 'La imagen no tiene la extension jpg o png'
					  ),
					  'checkUniqueName' => array(
						  'rule' => array('checkUniqueName'),
						  'message' => 'La imagen ya se encuentra registrada',
						  'on' => 'update'
					  ),		
	 		   )
	 		   */
        );
}
?>