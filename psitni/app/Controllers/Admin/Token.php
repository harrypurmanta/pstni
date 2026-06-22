<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Soalmodel;

class Token extends BaseController
{
    protected $session;
    protected $soalmodel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
        $this->ensureTokenTable();
    }

    private function ensureTokenTable() {
        $db = \Config\Database::connect();
        if (!$db->tableExists('token')) {
            $forge = \Config\Database::forge();
            $forge->addField([
                'token_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'token' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'materi_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'status_cd' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'normal',
                ],
                'created_dttm' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'created_user' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ]
            ]);
            $forge->addKey('token_id', true);
            $forge->createTable('token');
        } else {
            $forge = \Config\Database::forge();
            $fields_to_add = [];
            if (!$db->fieldExists('created_dttm', 'token')) {
                $fields_to_add['created_dttm'] = [
                    'type' => 'DATETIME',
                    'null' => true,
                ];
            }
            if (!$db->fieldExists('created_user', 'token')) {
                $fields_to_add['created_user'] = [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                ];
            }
            if (!empty($fields_to_add)) {
                $forge->addColumn('token', $fields_to_add);
            }
        }
    }

    public function index()
    {
        if ($this->session->get("user_nm") == "") {
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();
        $tokens = $db->table('token a')
                     ->select('a.*, b.materi_nm')
                     ->join('materi b', 'b.materi_id = a.materi_id', 'left')
                     ->where('a.status_cd', 'normal')
                     ->get()
                     ->getResult();

        $materi = $db->table('materi')
                     ->where('status_cd', 'normal')
                     ->get()
                     ->getResult();

        $data = [
            'tokens' => $tokens,
            'materi' => $materi
        ];

        return view('admin/token', $data);
    }

    public function simpan()
    {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $token = $this->request->getPost('token');
        $materi_id = $this->request->getPost('materi_id');

        if (empty($token) || empty($materi_id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Token dan Materi harus diisi']);
        }

        $db = \Config\Database::connect();
        
        $data = [
            'token' => strtoupper(trim($token)),
            'materi_id' => $materi_id,
            'status_cd' => 'normal',
            'created_dttm' => date('Y-m-d H:i:s'),
            'created_user' => $this->session->get('user_nm')
        ];

        $db->table('token')->insert($data);

        return $this->response->setJSON(['status' => 'sukses']);
    }

    public function hapus()
    {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $token_id = $this->request->getPost('token_id');
        if (empty($token_id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Token ID tidak valid']);
        }

        $db = \Config\Database::connect();
        $db->table('token')
           ->where('token_id', $token_id)
           ->update(['status_cd' => 'nullified']);

        return $this->response->setJSON(['status' => 'sukses']);
    }
}
