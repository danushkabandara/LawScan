<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danushka
 * Date: 8/25/13
 * Time: 10:30 PM
 * To change this template use File | Settings | File Templates.
 */
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class User extends AppModel{
    var $useDbConfig = 'default';
    var $useTable = 'users';
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';
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
        'username' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'firstname' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'lastname' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'company' => array(
            //'notempty' => array(
            //   'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            //  ),
        ),
        'jobtitle' => array(
            //  'notempty' => array(
            //   'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            //  ),
        ),
        'address' => array(
            //'notempty' => array(
            //   'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            // ),
        ),
        'city' => array(
            // 'notempty' => array(
            //   'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            // ),
        ),
        'state' => array(
            // 'notempty' => array(
            //   'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            // ),
        ),
        'country' => array(
            // 'notempty' => array(
            //   'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            // ),
        ),
        'zip' => array(
            // 'notempty' => array(
            'rule' => array('postal', null, 'us')
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            // ),
        ),
        'phone' => array(
            'rule' => array('phone', null, 'us')
        ),

        /* 'active' => array(
             'boolean' => array(
                 'rule' => array('boolean'),
                 //'message' => 'Your custom message here',
                 //'allowEmpty' => false,
                 //'required' => false,
                 //'last' => false, // Stop validation after this rule
                 //'on' => 'create', // Limit validation to 'create' or 'update' operations
             ),
         ),*/
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    /*   public $hasAndBelongsToMany = array(
           'Group' => array(
               'className' => 'Group',
               'joinTable' => 'groups_users',
               'foreignKey' => 'user_id',
               'associationForeignKey' => 'group_id',
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
       );*/


    public function beforeSave($options=array()){
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}