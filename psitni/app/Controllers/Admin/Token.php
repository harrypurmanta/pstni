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
        $materi_ids = $this->request->getPost('materi_id');
        $expired_dttm = $this->request->getPost('expired_dttm');

        if (empty($token) || empty($materi_ids)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Token dan Materi harus diisi']);
        }

        $expired_val = !empty($expired_dttm) ? date('Y-m-d H:i:s', strtotime($expired_dttm)) : null;

        $db = \Config\Database::connect();

        if (is_array($materi_ids)) {
            foreach ($materi_ids as $materi_id) {
                $data = [
                    'token' => strtoupper(trim($token)),
                    'materi_id' => $materi_id,
                    'status_cd' => 'normal',
                    'created_dttm' => date('Y-m-d H:i:s'),
                    'created_user' => $this->session->get('user_nm'),
                    'expired_dttm' => $expired_val
                ];
                $db->table('token')->insert($data);
            }
        } else {
            $data = [
                'token' => strtoupper(trim($token)),
                'materi_id' => $materi_ids,
                'status_cd' => 'normal',
                'created_dttm' => date('Y-m-d H:i:s'),
                'created_user' => $this->session->get('user_nm'),
                'expired_dttm' => $expired_val
            ];
            $db->table('token')->insert($data);
        }

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
