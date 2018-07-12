<?php

App::uses('AppModel', 'Model');

class Departamento extends AppModel {
	var $name = 'Departamento';
	var $displayField = 'nombre';

  var $hasMany = array(
  'Ciudad' => array(
  'className' => 'Ciudad',
  'foreignKey' => 'ciudad_id',
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
