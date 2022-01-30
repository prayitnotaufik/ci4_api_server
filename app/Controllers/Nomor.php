<?php

namespace App\Controllers;

use App\Models\NomorModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Nomor extends ResourceController
{
    use ResponseTrait;
    protected $nomor;

    public function __construct()
    {
        $this->nomor = new NomorModel();
    }

    public function index()
    {
        $data = $this->nomor->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->nomor->getWhere(['id' => $id])->getResult();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Data found with id ' . $id);
        }
    }

    public function create()
    {
        $data = [
            'no_hp' => $this->request->getVar('no_hp'),
            'provider' => $this->request->getVar('provider')
        ];

        // $data = json_decode(file_get_contents("php://input"));
        $this->nomor->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];

        return $this->respondCreated($response);
    }

    public function update($id = null)
    {
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'no_hp' => $json->no_hp,
                'provider' => $json->provider
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'no_hp' => $input['no_hp'],
                'provider' => $input['provider']
            ];
        }

        $this->nomor->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];

        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $data = $this->nomor->find($id);
        if ($data) {
            $this->nomor->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data found with id ' . $id);
        }
    }
}
