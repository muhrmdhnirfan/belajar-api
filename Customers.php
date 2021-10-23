<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_controller.php';

use Restserver\Libraries\REST_Controller;

class customers extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
    }

    //method GET untuk menampilkan data
    public function index_get()
    {

        $id = $this->get('id');
        if ($id == '') {
            $data = $this->db->get('customers')->result();
        } else {
            $this->db->where('customerID, $id');
            $data = $this->db->get('customers')->result();
        }
        $result = [
            "took" => $_SERVER["REQUEST_TIME_FLOAT"],
            "code" => 200,
            "message" => "Response seccessfully",
            "data" => $data
        ];
        $this->response($result, 200);

        header('Acess-Control-Allow-Origin: ');
        header('Access-Control-Allow-Methods: GET');
        $this->response($result, 200);
    }


    // method POST untuk menambah data
    public function index_post()
    {
        $data = array(
            'CustomerID' => $this->post('CustomerID'),
            'CompanyName' => $this->post('CompanyName'),
            'ContactTitle' => $this->post('ContactTitle'),
            'Address' => $this->post('Address'),
            'City' => $this->post('City'),
            'Region' => $this->post('Region'),
            'PostalCode' => $this->post('PostalCode'),
            'Country' => $this->post('Country'),
            'Phone' => $this->post('Phone'),
            'Fax' => $this->post('Fax')
        );

        $insert = $this->db->insert('customers', $data);
        if ($insert) {
            //$this->response ($data, 200);
            $result = [
                "took" => $_SERVER["REQUEST_TIME_FLOAT"],
                "code" => 201,
                "message" => "Data has succsessfully added",
                "data" => $data
            ];
        } else {
            $result = [
                "took" => $_SERVER["REQUEST_TIME_FLOAT"],
                "code" => 502,
                "message" => "Failed adding data",
                "data" => null
            ];
            $this->response($result, 502);
        }
    }

    //method PUT untuk mengubah data
    public function index_put()
    {
        $id = $this->put('id');
        $data = array(
            'CustomerID' => $this->post('CustomerID'),
            'CompanyName' => $this->post('CompanyName'),
            'ContactTitle' => $this->post('ContactTitle'),
            'Address' => $this->post('Address'),
            'City' => $this->post('City'),
            'Region' => $this->post('Region'),
            'PostalCode' => $this->post('PostalCode'),
            'Country' => $this->post('Country'),
            'Phone' => $this->post('Phone'),
            'Fax' => $this->post('Fax')
        );
        $this->db->where('CustomerID', $id);
        $update = $this->db->update('customer', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //methos DELETE untuk menghapus data
    public function index_delete()
    {
        $id = $this->delete('id');
        $this->db->where('CustomerID', $id);
        $delete = $this->db->delete('customers');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
