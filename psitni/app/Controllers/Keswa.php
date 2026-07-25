<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use App\Models\Usersmodel;
use CodeIgniter\HTTP\Message;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;
class Keswa extends BaseController
{
    protected $soalmodel;
    protected $usersmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->session->start();
        $this->soalmodel = new Soalmodel();
        $this->usersmodel = new Usersmodel();
	}

    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getMateriKeswa()->getResult()
            ];
            return view('front/keswa/materi',$data);
        }
    }

    public function pilihanMateri() {
        $request = \Config\Services::request();
        $data = [
            'materi_id' => $request->uri->getSegment(3),
            'group' => $this->soalmodel->getGroupByid($request->uri->getSegment(4))->getResult(),
        ];
        

        return view('front/keswa/pilihanmateri',$data);
    }

    public function ujian() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}

        $request = \Config\Services::request();
        $materi_id = $request->uri->getSegment(3);
        $data['group'] = $this->soalmodel->getGroupKeswa()->getResult();
        if ($request->uri->getSegment(4) == 8) {
            $kolom_id = 1;
        } else {
            $kolom_id = 0;
        }
        
        $data['soal'] = $this->soalmodel->getSoal(1,$request->uri->getSegment(4),$materi_id,$kolom_id)->getResult();
        $data['jawaban'] = $this->soalmodel->getjawaban($data['soal'][0]->soal_id)->getResult();
        $data['total_soal'] = $this->soalmodel->getTotalSoal(1,$request->uri->getSegment(3))->getResult();
        return view('front/keswa/tryout',$data);
    }
    
    public function startujian() {
        $request = \Config\Services::request();
        $soal_id = $this->request->getPost("soal_id");
        $jawaban_id = $this->request->getPost("jawaban_id");
        $group_id = $this->request->getPost("group_id");
        $no_soal = $this->request->getPost("no_soal");
        $pilihan_nm = $this->request->getPost("pilihan_nm");
        $kolom_id = $this->request->getPost("kolom_id");
        $materi = $this->request->getPost("materi");
        $proc = $this->request->getPost("proc");
        $waktu = $this->request->getPost("waktu");
        $date = date("Y-m-d H:i:s");
        $soal_nm = "";
        $res_ttlsoal = [];
        $jawaban_idx = "";
        $pilihan_nms = "";

        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "" && $pilihan_nm == "") {
            return $this->response->setJSON(["status" => "jawaban_kosong"]);
        } else {
            
            if ($proc == "prev" || $proc == "prevsoal" || $proc == "start") {

            } else {
                $getResponByid = $this->soalmodel->getResponByPrev($soal_id,$group_id,$materi,$this->session->user_id)->getResult();
                if (count($getResponByid)>0) {
                    $data = [
                        "jawaban_id" => $jawaban_id,
                        "pilihan_nm" => $pilihan_nm,
                        "soal_id" => $soal_id,
                        "no_soal" => $no_soal,
                        "group_id" => $group_id,
                        "materi" => $materi,
                        "created_user_id" => $this->session->user_id,
                        "created_dttm" => $date,
                        "used" => 0,
                        "kolom_id" => $kolom_id,
                    ];
        
                    $updaterespon = $this->soalmodel->updateResponPrev($soal_id,$jawaban_id,$group_id,$materi,$this->session->user_id,$data);
                } else {
                    if ($jawaban_id !== "null" && isset($soal_id)) {
                        $data = [
                            "jawaban_id" => $jawaban_id,
                            "pilihan_nm" => $pilihan_nm,
                            "soal_id" => $soal_id,
                            "no_soal" => $no_soal,
                            "group_id" => $group_id,
                            "materi" => $materi,
                            "used" => 0,
                            "kolom_id" => $kolom_id,
                            "created_user_id" => $this->session->user_id,
                            "created_dttm" => $date,
                        ];
            
                        $respon_id = $this->soalmodel->simpanRespon($data);
                    }
                }
            }
                if ($proc == "selesai") {
                    return $this->response->setJSON(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    
                    $res = $this->soalmodel->getSoal($no_soal,$group_id,$materi,$kolom_id)->getResult();
                    if (count($res) == 0 && $proc == "next") {
                        return $this->response->setJSON(array("proc" => "selesai"));
                    }
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $group_id = $res[0]->group_id;   
                        $kolom_id = $res[0]->kolom_id;
                        $res_ttlsoal = $this->soalmodel->getTotalSoal($group_id,$materi)->getResult();
                    }

                    // Ambil semua jawaban tersimpan untuk group dan materi ini secara sekaligus (bulk)
                    $all_respon = $this->soalmodel->getResponByGroupMateriUser($group_id, $materi, $this->session->user_id)->getResult();
                    $respon_map = [];
                    foreach ($all_respon as $resp) {
                        $respon_map[$resp->soal_id] = $resp->pilihan_nm;
                    }

                    $pilihan_nmx = isset($respon_map[$soal_id]) ? $respon_map[$soal_id] : "";

                    $box_list = [];
                    foreach ($res_ttlsoal as $boxsoal) {
                        $has_respon = isset($respon_map[$boxsoal->soal_id]);
                        $box_list[] = [
                            "no_soal" => (int)$boxsoal->no_soal,
                            "soal_id" => $boxsoal->soal_id,
                            "has_respon" => $has_respon,
                            "pilihan_nm" => $has_respon ? $respon_map[$boxsoal->soal_id] : ""
                        ];
                    }

                    $jawaban_list = [];
                    if (($group_id != 7 || ($group_id == 7 && $no_soal >= 1 && $no_soal <= 10)) && count($res) > 0) {
                        $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                        foreach ($getjawaban as $key) {
                            if ($pilihan_nmx == $key->pilihan_nm) {
                                $jawaban_idx = $key->jawaban_id;
                                $pilihan_nms = $key->pilihan_nm;
                            }
                            $jawaban_list[] = [
                                "jawaban_id" => $key->jawaban_id,
                                "pilihan_nm" => $key->pilihan_nm,
                                "jawaban_nm" => $key->jawaban_nm,
                                "jawaban_img" => $key->jawaban_img
                            ];
                        }
                    }
    
                    $getjumlahjawab = $this->soalmodel->getResponCountByMateriUser($group_id,$materi,$this->session->user_id)->getResult();
                    $jumlahjawab = (count($getjumlahjawab)>0) ? (int)$getjumlahjawab[0]->jumlah_jawab : 0;
                    
                    return $this->response->setJSON([
                        "soal_id" => $soal_id,
                        "soal_nm" => strip_tags($soal_nm),
                        "no_soal" => $no_soal,
                        "group_id" => $group_id,
                        "kolom_id" => $kolom_id,
                        "proc" => $proc,
                        "jawaban_idx" => $jawaban_idx,
                        "pilihan_nms" => $pilihan_nms,
                        "jumlah_jawab" => $jumlahjawab,
                        "total_soal_count" => count($res_ttlsoal),
                        "pilihan_nmx" => $pilihan_nmx,
                        "soal" => count($res) > 0 ? [
                            "soal_img" => $res[0]->soal_img,
                            "materi" => $res[0]->materi
                        ] : null,
                        "jawaban_list" => $jawaban_list,
                        "box_list" => $box_list,
                        "base_url" => base_url()
                    ]);
                }
        }
        
    }

    public function updateFinishRespon() {
        $materi_id = $this->request->getPost("materi_id");
        $group_id = $this->request->getPost("group_id");
        $user_id = $this->session->user_id;
        $data = [
            "status_cd" => "finish"
        ];
        $reset = $this->soalmodel->updateFinishRespon($materi_id,$group_id,$user_id,$data);

        echo json_encode($reset);exit;
    }

    public function hasiltryout() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}
        $request = \Config\Services::request();
        $user_id = $this->session->user_id;
        $materi_id = $request->uri->getSegment(3);
        $group_id = $request->uri->getSegment(4);
        $getRespon = $this->soalmodel->getResponPaket($group_id, $materi_id, $user_id)->getResult();

        
        $data = [
            "getRespon" => $getRespon
        ];
        
        return view('front/keswa/hasiltryout',$data);
    }
}