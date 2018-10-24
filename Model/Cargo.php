<?php
class Cargo extends AppModel {
	var $name = 'Cargo';
    var $displayField = 'nombre';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Centro' => array(
			'className' => 'Centro',
			'foreignKey' => 'centro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Curso' => array(
			'className' => 'Curso',
			'foreignKey' => 'curso_id',
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
		),
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Licencia' => array(
			'className' => 'Licencia',
			'foreignKey' => 'cargo_id',
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
		'Ciclo' => array(
			'className' => 'Ciclo',
			'joinTable' => 'cargos_ciclos',
			'foreignKey' => 'cargo_id',
			'associationForeignKey' => 'ciclo_id',
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
		'Docente' => array(
			'className' => 'Docente',
			'joinTable' => 'cargos_docentes',
			'foreignKey' => 'cargo_id',
			'associationForeignKey' => 'docente_id',
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
		'Empleado' => array(
			'className' => 'Empleado',
			'joinTable' => 'cargos_empleados',
			'foreignKey' => 'cargo_id',
			'associationForeignKey' => 'empleado_id',
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
	);

//Validaciones

        var $validate = array(
                   'nombre' => array(
                           'minLength' => array(
                           'rule' => array('minLength',5),
                           'allowEmpty' => false,
                           'message' => 'El nombre no es valido. Indicar una de las opciones.'
                           ),
                           'isUnique' => array(
	                       'rule' => 'isUnique',
	                       'message' => 'Este nombre de cargo esta siendo usado.'
	                     )                  						   
                   ),
                   'tipo' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 3), 
                           'allowEmpty' => false,       
                           'message' => 'El tipo no es valido. Indicar una de las opciones.'
                           )
                   ),
                   'resolucionNro' => array(
                           'minLength' => array(
                           'rule' => array('minLength',5),
                           'allowEmpty' => false,
                           'message' => 'La resolucion de creacion del cargo no es valida. Indicar una con este formato ejemplo: 1765/13.'
                           )
                   ),
                   'hsCatedra' => array(
                           'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => false,
                           'message' => 'Las horas catedras no son validas. Indicar una solo con numeros (ejemplo: 4).'
                           )
                   ),
                   /*'hsReloj' => array(
                           'numeric' => array(
                           'rule' => 'numeric',
                           'allowEmpty' => true,
                           'message' => 'Indicar una opcion.'
                           )
                   ),*/
                   'area' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 3), 
                           'allowEmpty' => false,       
                           'message' => 'El area de trabajo no es valida. Indicar una de las opciones.'
                           )
                   ),
                   'puesto' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 3), 
                           'allowEmpty' => false,       
                           'message' => 'El puesto de trabajo no es valido. Indicar una de las opciones.'
                           )
                   ),
                   'descripcion' => array(
                           'minLength' => array(
                           'rule' => array('minLength', 4), 
                           'allowEmpty' => true,       
                           'message' => 'Indicar una breve descripcion del cargo.'
                           )
                   ),
                   'fechaCreacion' => array(
                           'date' => array(
                           'rule' => 'date',
                           'allowEmpty' => false,
                           'message' => 'Indicar fecha de creacion del cargo.'
                           )
                   ),
                   'fechaCierre' => array(
                           'date' => array(
                           'rule' => 'date',
                           'allowEmpty' => true,
                           'message' => 'Indicar fecha de cierre del cargo.'
                           )
                   ),
                   'fechaAltaPersona' => array(
                           'date' => array(
                           'rule' => 'date',
                           'allowEmpty' => true,
                           'message' => 'Indicar fecha de alta de la persona afectada al cargo.'
                           )
                   ),
                   'fechaBajaPersona' => array(
                           'date' => array(
                           'rule' => 'date',
                           'allowEmpty' => true,
                           'message' => 'Indicar fecha de baja de la persona afectada al cargo.'
                           )
                   ),
                   'fechaCambioSituacionPersona' => array(
                           'date' => array(
                           'rule' => 'date',
                           'allowEmpty' => true,
                           'message' => 'Indicar fecha de cambio de situacion de la persona afectada al cargo.'
                           )
                   )
				  
         );
		 
		     
}
?>