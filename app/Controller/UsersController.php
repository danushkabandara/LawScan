<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danushka
 * Date: 8/25/13
 * Time: 10:47 PM
 * To change this template use File | Settings | File Templates.
 */

class UsersController extends AppController {
    var $uses = array( 'User','WorkOrder','Technician','Scan');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'logout', 'add', 'authenticate');
    }

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id){
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set("user", $this->User->read(null, $id));
    }
    public function  add() {

        $this->layout = 'login';
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->data)) {
                //  $this->_sendVerificationEmail($this->data);
                $this->Session->setFlash(__('The User has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.'));
            }
        }
        /*  $groups = $this->User->Group->find('list');
          $this->set(compact('groups'));*/
    }
    public function  edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The User has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
        //   $groups = $this->User->Group->find('list');
        // $this->set(compact('groups'));
    }
    public function

    delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete($id)) {
            $this->Session->setFlash(__('User deleted', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }


    public function login() {
             $this->layout = 'login';
        if($this->request->is('post')){
            if($this->Auth->login()){
                $this->redirect(Router::url('/', true)."/home/index/sort:client_last_name/direction:asc");
            } else {
                if($this->request->is('post')){
                    $this->Session->setFlash(__('Invalid username or password, try again'));
                }
            }
        }
    }
    public function

    logout() {
        $this->layout = 'login';
        $this->Session->setFlash('Logged out successfully');
        $this->redirect($this->Auth->logout());
    }


    protected function _sendVerificationEmail($userData, $options = array()) {
        App::uses('CakeEmail', 'Network/Email');
        $defaults = array(
            'from' => 'noreply@greenviewems.info',
            'subject' => __d('users', 'Account verification'),

            'layout' => 'default',
            'emailFormat' => CakeEmail::MESSAGE_TEXT
        );

        $options = array_merge($defaults, $options);

        $Email = new CakeEmail('smtp');

        $Email->to($userData[$this->modelClass]['email'])
            ->from('admin@greenviewems.info')
            ->emailFormat($options['emailFormat'])
            ->subject($options['subject'])
            ->template($options['template'], $options['layout'])
            ->viewVars(array(
                'model' => $this->modelClass,
                'user' => $userData
            ))
            ->send();

    }

    public function authenticate() {

        $this->render(false);
        $username = $this->request->data["username"];
        $password = $this->request->data["password"];
		 $data = array('username'=>$username, 'password'=>$password);
        $technician = $this->Technician->find('first', array(
            'conditions' => array('Technician.username' => $username)
        ));
        if(count($technician)==0)
        {
            $this->response->header('Content-type: text');
            $this->response->body('fail');
            $this->response->send();//sends success response to device
        }

        else if($this->Auth->login($data))
        {
            $scanEntry= $this->Scan->find('first', array('conditions'=>array('Scan.technician_id'=>$username), 'order'=>array('Scan.id'=>'DESC')));
            if(count($scanEntry)==0)//user has never scanned in
            {
                $this->response->header('Content-type: text');
                $this->response->body('pass,0,0,0,0,0');
                $this->response->send();//sends success response to device
            }
            else if($scanEntry['Scan']['end_time']=='0000-00-00 00:00:00')//open scan, not on break
            {
                $activity = $scanEntry['Scan']['activity'];
                $rate = $scanEntry['Scan']['billing_rate'];
                $this->response->header('Content-type: text');
                $this->response->body('pass,0,0,'.$activity.','.$scanEntry['Scan']['start_time'].','.$rate);
                $this->response->send();//sends success response to device
            } else {
                $this->response->header('Content-type: text');
                $this->response->body('pass,0,0,0,0,0');
                $this->response->send();//sends success response to device
            }
        }
        else
        {
            $this->response->header('Content-type: text');
            $this->response->body('fail');
            $this->response->send();//sends success response to device

        }



    }


}
?>