<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
// use namespace
use Restserver\Libraries\REST_Controller;
class Api extends REST_Controller {
    function __construct(){
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
    public function users_get(){
        $this->db->select('*')->from('user')->order_by('id','ASC');
        $users = $this->db->get()->result_array();
        $id = $this->get('id');
        if ($id === NULL){
            if ($users){
                // jika user terdapat isinya
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else{
                // jika user kosong
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            $this->db->select('*')->from('user')->where('id',$id);
            $users = $this->db->get()->result_array();
            if (!empty($users)){
                foreach ($users as $key => $value){
                    if (isset($value['id']) && $value['id'] === $id) {
                        $user = $value;
                    }
                }
            }
            if (!empty($user)){
                $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function users_post(){
        // $this->some_model->update_user( ... );
        $message = [
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function users_delete(){
        $id = (int) $this->get('id');
        // Validate the id.
        if ($id <= 0){
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
