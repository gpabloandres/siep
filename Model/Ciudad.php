<?php
class Ciudad extends AppModel {
	var $name = 'Ciudad';
	var $displayField = 'nombre';

     var $hasMany = array(
		'Barrio' => array(
			'className' => 'Barrio',
			'foreignKey' => 'barrio_id',
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
}

?>
