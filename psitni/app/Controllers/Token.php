<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Usersmodel;
use App\Models\Soalmodel;
use App\Models\Tokenmodel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Token extends BaseController
{
    protected $usermodel;
    protected $soalmodel;
    protected $tokenmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->usermodel = new Usersmodel();
        $this->soalmodel = new Soalmodel();
        $this->tokenmodel = new Tokenmodel();
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
                ],
                'expired_dttm' => [
                    'type' => 'DATETIME',
                    'null' => true,
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
            if (!$db->fieldExists('expired_dttm', 'token')) {
                $fields_to_add['expired_dttm'] = [
                    'type' => 'DATETIME',
                    'null' => true,
                ];
            }
            if (!empty($fields_to_add)) {
                $forge->addColumn('token', $fields_to_add);
            }
        }
    }


    public function checktoken()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $token = $this->request->getPost('token');
            $materi_id = $this->request->getPost('materi_id');
            $now = date('Y-m-d H:i:s');
            $db = \Config\Database::connect();
            $check = $db->table('token')
                        ->where('token', $token)
                        ->where('materi_id', $materi_id)
                        ->where('status_cd', 'normal')
                        ->groupStart()
                            ->where('expired_dttm', null)
                            ->orWhere('expired_dttm >=', $now)
                        ->groupEnd()
                        ->get()
                        ->getResult();
                        
            if (count($check) > 0) {
                $ret = "sukses";
            } else {
                $ret = "gagal";
            }
            echo json_encode($ret);
        }
    }

    public function InsertNoTest() {
        $notest = $this->request->getPost('notest');
        $group_id = $this->request->getPost('group_id');
       
        $dataexam = [
            "group_id" => $group_id,
            "materi_id" => 1,
            "user_id" => $this->session->user_id,
            "no_antrian" => $notest,
        ];
        $insertexam = $this->soalmodel->insertexam($dataexam);
        if ($insertexam) {
            $ret = "sukses"; 
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }
}
