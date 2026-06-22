<?php

namespace App\Controllers;
use App\Models\Soalmodel;
class Materi extends BaseController
{
    protected $soalmodel;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->soalmodel = new Soalmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'materiSK' => $this->soalmodel->getMateriSK()->getResult(),
            ];
            return view('front/materi',$data);
        }
    }

    public function pilihanMateri() {
        $request = \Config\Services::request();
        $data = [
            'materi_id' => $request->uri->getSegment(3),
            'group' => $this->soalmodel->getGroupByid($request->uri->getSegment(4))->getResult(),
        ];
        

        return view('front/pilihanmateri',$data);
    }

    public function riwayathidup() {
        $request = \Config\Services::request();
        $db = \Config\Database::connect();
        
        // Ensure religion table exists and is seeded
        $this->ensureReligionTable();
        
        $religions = $db->table('religion')
                        ->where('status_cd', 'normal')
                        ->get()
                        ->getResult();

        $data = [
            'materi_id' => $request->uri->getSegment(3),
            'religions' => $religions
        ];
        
        return view('front/riwayathidup',$data);
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


    public function simpanriwayathidup() {
        if ($this->session->get("user_nm") == "") {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired']);
        }

        $person_id = $this->session->get('person_id');
        if (empty($person_id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Person ID tidak ditemukan']);
        }

        $person_nm = $this->request->getPost('person_nm');
        $birth_place = $this->request->getPost('birth_place');
        $birth_dttm = $this->request->getPost('birth_dttm');
        $religion = $this->request->getPost('religion');
        $ortu_nm = $this->request->getPost('ortu_nm');
        $ortu_job = $this->request->getPost('ortu_job');
        $addr_txt = $this->request->getPost('addr_txt');

        $db = \Config\Database::connect();
        
        // Ensure religion column exists in person table
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

        $data = [
            'person_nm'   => $person_nm,
            'birth_place' => $birth_place,
            'birth_dttm'  => $birth_dttm,
            'religion'    => $religion,
            'ortu_nm'     => $ortu_nm,
            'ortu_job'    => $ortu_job,
            'addr_txt'    => $addr_txt,
            'updated_dttm'=> date("Y-m-d H:i:s"),
            'updated_user'=> $this->session->get("user_nm")
        ];

        $db->table('person')->where('person_id', $person_id)->update($data);

        // Update session data
        $this->session->set($data);

        return $this->response->setJSON(['status' => 'sukses']);
    }
}
