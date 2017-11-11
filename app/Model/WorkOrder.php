<?php
App::uses('AppModel', 'Model');
/**
 * WorkOrder Model
 *
 * @property Technician
 */
class WorkOrder extends AppModel {


public $virtualFields = array(
    'full_name' => 'CONCAT(WorkOrder.client_last_name, ", ", WorkOrder.client_first_name)'
);
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'full_name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'client_first_name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),

                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'client_last_name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),

                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'file_no' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),

				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'case_no' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),

                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'court' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),

                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

		'start_time' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'start_date' => array(
            'date' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
		'completion_time' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'estimated_completion_time' => array(
            'datetime' => array(
                'rule' => array('datetime'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'created_time' => array(
            'datetime' => array(
                'rule' => array('datetime'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'retainer' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'disbursement' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'billing_rate' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'advanced_hours' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'address' => array(
                           //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
        ),
        'nature_of_work' => array(
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
        ),
        'billing_method' => array(
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
        ),
        'serialized_expense_reimbursements' => array(
        ),
        'serialized_expense_reimbursements_dates' => array(
        ),
        'serialized_expense_reimbursements_types' => array(
        ),
        'serialized_additional_retainers' => array(
        ),
        'serialized_additional_retainers_dates' => array(
        )

    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Technician' => array(
			'className' => 'Technician',
			'joinTable' => 'work_orders_technicians',
			'foreignKey' => 'work_order_id',
			'associationForeignKey' => 'technician_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

    public function beforeSave($options = array()) {
        if (!empty($this->data['expense_reimbursements']))
        {
            $this->data['WorkOrder']['serialized_expense_reimbursements'] = serialize($this->data['expense_reimbursements']);
            $this->data['WorkOrder']['serialized_expense_reimbursement_dates'] = serialize($this->data['expense_reimbursement_dates']);
            $this->data['WorkOrder']['serialized_expense_reimbursement_types'] = serialize($this->data['expense_reimbursement_types']);
        }
        if (!empty($this->data['additional_retainers'])) {
            $this->data['WorkOrder']['serialized_additional_retainers'] = serialize($this->data['additional_retainers']);
            $this->data['WorkOrder']['serialized_additional_retainers_dates'] = serialize($this->data['additional_retainers_dates']);
        }
        return true;
    }
    public static function billingMethod($value = null) {
        $options = array(
            1 => __('Real time rule',true),
            2 => __('Tenths rule',true),
            3 => __('Fifteenths rule', true)



        );
        if($value == null)
            return $options;
        else
            return ($options[$value]);
    }

}
