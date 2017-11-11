<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array( 'Session', 'RequestHandler',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'home', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'home', 'action' => 'index'),
            'authorize' => array('Controller'),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username', 'password'),
					'passwordHasher' => 'Blowfish'
                )
            )
        )
    );
    // We need the Auth component for our authentication system
    // And the Session component is needed for displaying flash messages.

    public function isAuthorized($user) {
        $this->set('userName', $this->Auth->user('username'));
        return true;
    }

    public function beforeFilter() {
        $this->set('userName', $this->Auth->user('username'));
        $this->Auth->allow(
            array(
                'WorkOrders/addFromReader',
                'Scans/add',
                'Users/authenticate'
            )
        );
    }
}
