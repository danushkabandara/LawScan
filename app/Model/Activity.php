<?php

App::uses('AppModel', 'Model');
class Activity extends AppModel{
    var $useDbConfig = 'default';
    var $useTable = 'activities';
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    public $hasOne = array(
        'Scan'=> array(
            'className'=>'Scan',
            'foreignKey'=>'activity'
        )
    );
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );

}