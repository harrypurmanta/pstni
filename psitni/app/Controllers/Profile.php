<?php

namespace App\Controllers;

use App\Models\Usersmodel;

class Profile extends BaseController
{
    protected $session;
    protected $usersmodel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->usersmodel = new Usersmodel();
    }

    public function index()
    {
        if ($this->session->get("user_nm") == "") {
            return redirect()->to('/');
        }

        $user_id = $this->session->get('user_id');
        $user_data = $this->usersmodel->getbyUserId($user_id)->getRow();

        $db = \Config\Database::connect();
        
        // Ensure religion table exists
        $this->ensureReligionTable();
        
        $religions = $db->table('religion')
                        ->where('status_cd', 'normal')
                        ->get()
                        ->getResult();

        $data = [
            'user' => $user_data,
            'religions' => $religions
        ];

        return view('front/profile', $data);
    }

    public function update()
    {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $user_id = $this->session->get('user_id');
        $user_data = $this->usersmodel->getbyUserId($user_id)->getRow();

        if (!$user_data) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User tidak ditemukan']);
        }

        $person_id = $user_data->person_id;

        $person_nm = $this->request->getPost('person_nm');
        $satuan = $this->request->getPost('satuan');
        $birth_place = $this->request->getPost('birth_place');
        $birth_dttm = $this->request->getPost('birth_dttm');
        $cellphone = $this->request->getPost('cellphone');
        $addr_txt = $this->request->getPost('addr_txt');
        $gender_cd = $this->request->getPost('gender_cd');
        
        $religion = $this->request->getPost('religion');
        $ortu_nm = $this->request->getPost('ortu_nm');
        $ortu_job = $this->request->getPost('ortu_job');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        
        // Check cellphone duplicate (excluding current person)
        $cellCheck = $db->table('person')
                        ->where('cellphone', $cellphone)
                        ->where('person_id !=', $person_id)
                        ->where('status_cd', 'normal')
                        ->get()
                        ->getResult();
                        
        if (count($cellCheck) > 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No. Handphone sudah digunakan oleh akun lain.']);
        }

        // Check if religion column exists in person table
        if (!$db->fieldExists('religion', 'person')) {
            $forge = \Config\Database::forge();
            $forge->addColumn('person', [
                'religion' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ]
            ]);
        }

        $personData = [
            'person_nm'   => $person_nm,
            'satuan'      => $satuan,
            'birth_place' => $birth_place,
            'birth_dttm'  => $birth_dttm,
            'cellphone'   => $cellphone,
            'addr_txt'    => $addr_txt,
            'gender_cd'   => $gender_cd,
            'religion'    => $religion,
            'ortu_nm'     => $ortu_nm,
            'ortu_job'    => $ortu_job,
            'updated_dttm'=> date("Y-m-d H:i:s"),
            'updated_user'=> $this->session->get("user_nm")
        ];

        $db->table('person')->where('person_id', $person_id)->update($personData);

        // If password is changed, update it too
        if (!empty($password)) {
            $userData = [
                'pwd0' => md5($password),
                'update_dttm' => date("Y-m-d H:i:s"),
                'update_user' => $this->session->get("user_nm")
            ];
            $db->table('users')->where('user_id', $user_id)->update($userData);
            $this->session->set('pwd0', md5($password));
        }

        // Update session
        $this->session->set($personData);

        return $this->response->setJSON(['status' => 'sukses']);
    }

    private function ensureReligionTable() {
        $db = \Config\Database::connect();
        if (!$db->tableExists('religion')) {
            $forge = \Config\Database::forge();
            
            $forge->addField([
                'religion_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'religion_nm' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'status_cd' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'normal',
                ],
                'created_dttm' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ]
            ]);
            $forge->addKey('religion_id', true);
            $forge->createTable('religion');

            // Seed initial data
            $initialData = [
                ['religion_nm' => 'Islam', 'created_dttm' => date('Y-m-d H:i:s')],
                ['religion_nm' => 'Kristen Protestan', 'created_dttm' => date('Y-m-d H:i:s')],
                ['religion_nm' => 'Kristen Katolik', 'created_dttm' => date('Y-m-d H:i:s')],
                ['religion_nm' => 'Hindu', 'created_dttm' => date('Y-m-d H:i:s')],
                ['religion_nm' => 'Buddha', 'created_dttm' => date('Y-m-d H:i:s')],
                ['religion_nm' => 'Khonghucu', 'created_dttm' => date('Y-m-d H:i:s')],
                ['religion_nm' => 'Lainnya', 'created_dttm' => date('Y-m-d H:i:s')],
            ];
            $db->table('religion')->insertBatch($initialData);
        }
    }
}
