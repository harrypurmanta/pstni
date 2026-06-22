<?php

namespace App\Controllers;
use App\Models\Soalmodel;
use App\Models\Usersmodel;
use CodeIgniter\HTTP\Message;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;
class Tryout extends BaseController
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
		}

        $request = \Config\Services::request();
        $materi_id = $request->uri->getSegment(2);
        $data['group'] = $this->soalmodel->getGroup()->getResult();
        $data['soal'] = $this->soalmodel->getSoal(1,1,$materi_id,0)->getResult();
        $data['jawaban'] = $this->soalmodel->getjawaban($data['soal'][0]->soal_id)->getResult();
        $data['total_soal'] = $this->soalmodel->getTotalSoal(1,$request->uri->getSegment(2))->getResult();
        return view('front/tryout',$data);
    }

    public function ujian() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}

        $request = \Config\Services::request();
        $materi_id = $request->uri->getSegment(3);
        $data['group'] = $this->soalmodel->getGroup()->getResult();
        if ($request->uri->getSegment(4) == 8) {
            $kolom_id = 1;
        } else {
            $kolom_id = 0;
        }
        
        $data['soal'] = $this->soalmodel->getSoal(1,$request->uri->getSegment(4),$materi_id,$kolom_id)->getResult();
        $data['jawaban'] = $this->soalmodel->getjawaban($data['soal'][0]->soal_id)->getResult();
        $data['total_soal'] = $this->soalmodel->getTotalSoal(1,$request->uri->getSegment(3))->getResult();
        return view('front/tryout',$data);
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
        $jawaban = "";
        $boxnomorsoal = "";
        $res_ttlsoal = "";
        $sisawaktu = "";
        $jawaban_idx = "";
        $pilihan_nms = "";
        if ($jawaban_id == "null") {

        } else if ($proc == "next" && $jawaban_id == "" && $pilihan_nm == "") {
            echo json_encode("jawaban_kosong");
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
                        // "session" => $this->session->session
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
                            // "session" => $this->session->session
                        ];
            
                        $respon_id = $this->soalmodel->simpanRespon($data);
                    }
                }
            }
                if ($proc == "selesai") {
                    echo json_encode(array("proc" => $proc));
                } else {
                    if ($proc == "prevsoal") {
                        $no_soal = $no_soal - 1;
                    } else if ($proc == "next") {
                        $no_soal = $no_soal + 1;
                    }
                    
                    $res = $this->soalmodel->getSoal($no_soal,$group_id,$materi,$kolom_id)->getResult();
                    // echo json_encode($res);exit;
                    if (count($res)>0) {
                        $soal_nm = $res[0]->soal_nm;
                        $soal_id = $res[0]->soal_id;
                        $group_id = $res[0]->group_id;   
                        $kolom_id = $res[0]->kolom_id;
                        $res_ttlsoal = $this->soalmodel->getTotalSoal($group_id,$materi)->getResult();
                    } 
                    foreach ($res_ttlsoal as $boxsoal) {
                        $getResponBox = $this->soalmodel->getResponBox($boxsoal->soal_id,$group_id,$materi,$this->session->user_id)->getResult();
                        $boxclick = "onclick='setboxsoal($boxsoal->no_soal)'";
                        $boxcursor = "cursor:pointer;";

                        if (count($getResponBox)>0) {
                            $pilihan_nm = " ".$getResponBox[0]->pilihan_nm;
                            $style="border:2px solid #3cce3c;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $getResponBox[0]->pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        } else {
                            $pilihan_nm = "";
                            $style="border:2px solid red;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            if ($boxsoal->no_soal == $no_soal) {
                                $pilihan_nmx = $pilihan_nm;
                                $style="border:2px solid blue;width:14%;height:36px;padding:5px;margin:5px;border-radius:5px;$boxcursor";
                            }
                        }
                        $boxnomorsoal .= "<div class='col-md-2' style='$style font-size:12px;'>".$boxsoal->no_soal."$pilihan_nm</div>";
                    }
                    

                    if ($res[0]->soal_img == "") {
                        $img_soal = "";
                    } else {
                        $img_soal = "<div class='col-sm-10'>
                        <a href='".base_url()."/images/soal/materi/".$res[0]->materi."/besar/".$res[0]->soal_img."' data-toggle='lightbox'>
                        <img style='max-width: 350px;max-height: 100%;' src='".base_url()."/images/soal/materi/".$res[0]->materi."/".$res[0]->soal_img."' class='img-fluid'>
                        </a>
                    </div>";
                    }

                    if ($group_id == 7) {
                        $jawaban = "<div class='btn col-md-12' style='margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;'>
                            <input type='text' class='form-control' name='inp_pilihan_nm_7' id='inp_pilihan_nm_7' placeholder='Jawaban' autocomplete='off' value='' style='color:black;font-size:16px;'>
                        </div>";
                    } else {
                        $getjawaban = $this->soalmodel->getjawaban($res[0]->soal_id)->getResult();
                        foreach ($getjawaban as $key) {
                            if ($pilihan_nmx == $key->pilihan_nm) {
                                $jawaban_idx = $key->jawaban_id;
                                $pilihan_nms = $key->pilihan_nm;
                                $border = "margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align: left;border: thick solid rgb(0, 166, 90);";
                            } else {
                                $border = "";
                            }
                            
                            if ($key->jawaban_img == "") {
                                $img_jwb = "";
                            } else {
                                $img_jwb = "<img style='max-width:350px;height:100%;' src='".base_url()."/images/jawaban/materi/".$res[0]->materi."/group/".$group_id."/".$key->jawaban_img."'>";
                            }
                            
                            $jawaban .= "
                                <div id='dv_jawaban_".$key->jawaban_id."' 
                                    onclick='selectJawaban(".$key->jawaban_id.",\"".$key->pilihan_nm."\")' 
                                    class='btn col-md-12 jawaban_dv' 
                                    style='margin-top:10px;margin-bottom:10px;background-color:#aeaebb;border-radius:5px;text-align:left;
                                            word-break: break-all; overflow-wrap: break-word; white-space: normal;'>
                                    
                                    <label for='pilihan_nm'>".$key->pilihan_nm.". </label> 

                                    <span>
                                        ".$key->jawaban_nm."
                                    </span>

                                    <div>$img_jwb</div>
                                </div>";
                        }
                    }
    
                    
                    $button = "";
                    $getjumlahjawab = $this->soalmodel->getResponCountByMateriUser($group_id,$materi,$this->session->user_id)->getResult();
                    if (count($getjumlahjawab)>0) {
                        $jumlahjawab = $getjumlahjawab[0]->jumlah_jawab;
                    } else {
                        $jumlahjawab = 0;
                    }
                    
                    

                    $button .= "<button onclick='startujian(\"next\")' style='font-size:16px;padding-left:25px;padding-right:25px;' class='btn btn-success'>Next</button>";
                    
                    if ($jumlahjawab == count($res_ttlsoal) - 1) {
                        $button .= "<button onclick='startujian(\"selesai\")' style='font-size:16px;padding-left:25px;padding-right:25px; margin-left: 20px;' class='btn btn-warning'>Selesai</button>";
                    } 
                    // echo json_encode($soal_nm);exit;
                    echo json_encode(array("soal_id"=>$soal_id, "soal_nm" => strip_tags($soal_nm),"no_soal"=>$no_soal, "group_id"=>$group_id,"kolom_id"=>$kolom_id, "jawaban_nm" => $jawaban, "boxnomorsoal" => $boxnomorsoal, "button" => $button, "proc" => $proc, "img_soal"=>$img_soal,"jawaban_idx"=>$jawaban_idx,"pilihan_nms"=>$pilihan_nms,"jumlah_jawab"=>$jumlahjawab));
                }
        }
        
    }

    public function ujianPauli() {
        $request = \Config\Services::request();
        $data["materi_id"]  = $request->uri->getSegment(3);
        $data["group_id"]   = $request->uri->getSegment(4);
        $kolom_id = 0;
        
        return view('front/pauli/ujian',$data);
    }

    public function pauliujian() {
        $req = $this->request;

        $proc        = $req->getPost("proc");
        $soal_id     = $req->getPost("soal_id");
        $jawaban_id  = $req->getPost("jawaban_id");
        $group_id    = $req->getPost("group_id");
        $no_soal     = (int)$req->getPost("no_soal");
        $pilihan_nm  = $req->getPost("pilihan_nm");
        $kolom_id    = (int)$req->getPost("kolom_id");
        $materi      = $req->getPost("materi");
        $sk_group_id = (int)$req->getPost("sk_group_id");
        
        $user_id = $this->session->user_id;
        
        $date = date("Y-m-d H:i:s");

        if (!$this->session->has('used')) {
            $this->session->set('used', 1);
        }

        if ($jawaban_id != "") {
            $data = [
                "jawaban_id"      => $jawaban_id,
                "pilihan_nm"      => $pilihan_nm,
                "soal_id"         => $soal_id,
                "no_soal"         => $no_soal,
                "group_id"        => $group_id,
                "materi"          => $materi,
                "used"            => $this->session->used,
                "kolom_id"        => $kolom_id,
                "created_user_id" => $user_id,
                "created_dttm"    => $date,
                "session"         => $this->session->session
            ];
            
            $exists = $this->soalmodel->getResponPauli($soal_id, $group_id, $materi, $user_id, $sk_group_id)->getResult();
            
            if (count($exists) > 0) {
                $updaterespon = $this->soalmodel->updateResponPauli($soal_id,$group_id,$materi,$user_id,$sk_group_id,$data);
            } else {
                $this->soalmodel->simpanResponSK($data);
            }
        }
        
        $no_soal++;

        if ($proc === "persiapan" || $no_soal == 51 && $group_id == 9 && $kolom_id <= 20 && $sk_group_id <= 4) {
            return $this->response->setJSON([
                "ret" => "persiapan",
                "kolom_id" => $kolom_id,
                "sk_group_id" => $sk_group_id
            ]);
        }

        if ($proc === "selesai") {
            return $this->response->setJSON(["ret" => "selesai"]);
        }
        
        $soal = $this->soalmodel->getSoalPauliFast($no_soal, $group_id, $materi, $kolom_id, $sk_group_id);

        if (!$soal) {
            return $this->response->setJSON(["ret" => "soal_tidak_ada"]);
        }

        $jawaban = $this->soalmodel->getjawabanPauli($soal->soal_id)->getResult();

        return $this->response->setJSON([
            "ret" => "ok",
            "no_soal" => $no_soal,
            "kolom_id" => $kolom_id,
            "group_id" => $group_id,
            "sk_group_id" => $sk_group_id,
            "data_soal" => [
                "soal_id" => $soal->soal_id,
                "soal_nm" => $soal->soal_nm,
                "jawaban" => $jawaban
            ]
        ]);
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
        $getRespon = $this->soalmodel->getResponPaket($group_id,$materi_id,$user_id)->getResult();

        $hasil = [];
        $lastUsed = $this->soalmodel->getLastUsedPauli($user_id, $group_id, $materi_id)->getRow();
        $user = $this->usersmodel->getbyUserId($user_id)->getResult();
        for ($i = 1; $i <= 4; $i++) {
            $hasil[$i] = $this->soalmodel
                ->getHasilPauliByUserUsed(
                    $user_id,
                    $i, // sk_group_id,
                    $materi_id,
                    1
                )
                ->getResult();
        }
        
        $data = [
            "hasil" => $hasil,
            "getRespon" => $getRespon
        ];
        
        return view('front/hasiltryout',$data);
    }

    function saveChart($base64, $name)
    {
        $base64 = str_replace('data:image/png;base64,', '', $base64);
        $base64 = str_replace(' ', '+', $base64);
        $data = base64_decode($base64);

        $file = WRITEPATH . 'upload/chartpauli/chart_' . $name . '.png';
        file_put_contents($file, $data);

        return $file;
    }

    private function buildTablePauli($data)
    {
        $html = '
        <table border="1" cellpadding="3" cellspacing="0" width="100%">
            <tr>
                <th width="10%" align="center"><b>No</b></th>
                <th width="30%" align="center"><b>Kolom</b></th>
                <th width="20%" align="center"><b>Terjawab</b></th>
                <th width="20%" align="center"><b>Tdk</b></th>
                <th width="20%" align="center"><b>Salah</b></th>
            </tr>
        ';

        $no = 1;
        foreach ($data as $row) {
            $html .= '
            <tr>
                <td align="center">'.$no++.'</td>
                <td>'.$row->kolom_nm.'</td>
                <td align="center">'.$row->terjawab.'</td>
                <td align="center">'.$row->tidak_terjawab.'</td>
                <td align="center">'.$row->salah.'</td>
            </tr>';
        }

        $html .= '</table>';

        return $html;
    }

    public function kirimemail() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}
        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf2 = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf3 = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        $mailService = \Config\Services::email();
        $user_id = $this->session->user_id;
        $materi_id = $this->request->getPost("materi");
        $group_id = $this->request->getPost("group_id");
        $chart1 = $this->request->getPost('chart1');
        $chart2 = $this->request->getPost('chart2');
        $chart3 = $this->request->getPost('chart3');
        $chart4 = $this->request->getPost('chart4');

        $chart1File = $this->saveChart($chart1, $materi_id.'_'.$this->session->user_nm.'_1');
        $chart2File = $this->saveChart($chart2, $materi_id.'_'.$this->session->user_nm.'_2');
        $chart3File = $this->saveChart($chart3, $materi_id.'_'.$this->session->user_nm.'_3');
        $chart4File = $this->saveChart($chart4, $materi_id.'_'.$this->session->user_nm.'_4');

        $mhs = $this->usersmodel->getbyUserId($user_id)->getResult();
        if (empty($mhs)) {
            return $this->response->setJSON([
                "status" => false,
                "message" => "Data user tidak ditemukan"
            ]);
        }
        
        $getResponHasilSalah = $this->soalmodel->getResponHasilSalah($group_id, $materi_id, $user_id)->getResult();
        // echo json_encode($getResponHasilSalah);exit;
        if (empty($getResponHasilSalah)) {
            return $this->response->setJSON([
                "status" => false,
                "message" => "Data respon tidak ditemukan"
            ]);
        }

        // $tabelHasil = '
        //     <h3 style="text-align:center;">Rekap Nilai per Paket</h3>
        //     <table border="1" cellpadding="5" cellspacing="0" width="100%">
        //         <tr>
        //             <th width="40%" align="center"><b>Paket</b></th>
        //             <th width="30%" align="center"><b>Benar</b></th>
        //             <th width="30%" align="center"><b>Salah</b></th>
        //         </tr>';

        // foreach ($getResponHasilSalah as $key) {
        //     $tabelHasil .= '
        //     <tr>
        //         <td align="center">'.$key->group_nm.'</td>
        //         <td align="center">'.$key->total_benar.'</td>
        //         <td align="center">'.$key->total_salah.'</td>
        //     </tr>';
        // }

        // $tabelHasil .= '</table>';
        $pdf2 = new TCPDF();
        $pdf2->AddPage();
        $pdf2->setPrintHeader(false);
        $pdf2->setPrintFooter(false);
        // $filename = str_replace(" ", "_", $mhs[0]->person_nm)."_materi".$materi_id.".pdf";

        $soalsalah = "";
        $currentGroup = "";

        if (count($getResponHasilSalah)>0) {
            foreach ($getResponHasilSalah as $key) {
                $soal_nm = $key->soal_nm == '' ? '-' : $key->soal_nm ?? '-';
                $pilihan_nm = $key->pilihan_nm ?? '-';
                $kunci = $key->kunci ?? '-';
                $pembahasan = $key->pembahasan == '' ? '-' : $key->pembahasan ?? '-';
                $no_soal = $key->no_soal ?? '-';

                if ($currentGroup != $key->group_nm) {
                    $currentGroup = $key->group_nm;

                    $soalsalah .= '
                        <h3 style="background-color:#eee; padding:5px;">
                            '.$currentGroup.'
                        </h3>
                    ';
                }
                
                $basePath = str_replace('\\', '/', FCPATH);

                // Gambar pembahasan
                $pembahasan_img = "";
                if (!empty($key->pembahasan_img)) {
                    $path = $basePath . 'images/pembahasan/' . $key->materi . '/' . $key->pembahasan_img;

                    if (file_exists($path)) {
                        $pembahasan_img = '<img src="'.$path.'" width="150">';
                    } else {
                        $pembahasan_img = '';
                    }
                }

                // Gambar soal
                $img_soal = "";
                if (!empty($key->soal_img)) {
                    $path = $basePath . 'images/soal/materi/' . $key->materi . '/' . $key->soal_img;

                    if (file_exists($path)) {
                        $img_soal = '<img src="'.$path.'" width="250">';
                    } else {
                        $img_soal = '';
                    }
                }

                // Hanya tampilkan yang salah
                if ($key->pilihan_nm != $kunci) {
                    $soalsalah .= '
                    <div style="margin-bottom:15px;">
                        <b>Soal No. '.$no_soal.'</b><br>
                        <table border="1" cellpadding="4" cellspacing="0" width="100%" style="font-size:12px;">
                            <tr>
                                <td width="20%">Pertanyaan</td>
                                <td width="3%">:</td>
                                <td width="77%">'.strip_tags($soal_nm).' '.$img_soal.'</td>
                            </tr>
                            <tr>
                                <td>Jawaban</td>
                                <td>:</td>
                                <td>'.$pilihan_nm.'</td>
                            </tr>
                            <tr>
                                <td>Kunci</td>
                                <td>:</td>
                                <td>'.$kunci.'</td>
                            </tr>
                            <tr>
                                <td>Pembahasan</td>
                                <td>:</td>
                                <td>'.strip_tags($pembahasan).' '.$pembahasan_img.'</td>
                            </tr>
                        </table>
                    </div>';
                }
            }
        }

        if (empty($soalsalah)) {
            $soalsalah = '<p>Tidak ada soal salah</p>';
        }
        
        $pdf2->writeHTML('<hr>', true, false, true, false, '');
        $pdf2->writeHTML($soalsalah, true, false, true, false, '');

        $filenameSalah = str_replace(" ", "_", $mhs[0]->person_nm)."_materi".$materi_id."_SALAH.pdf";
        $filePathSalah = WRITEPATH . 'upload/salah/' . $filenameSalah;
        $pdf2->Output($filePathSalah, 'F'); // simpan ke file

        $filenamePauli = str_replace(" ", "_", $mhs[0]->person_nm)."_materi".$materi_id."_PAULI.pdf";
        $filePathPauli = WRITEPATH . 'upload/pauli/' . $filenamePauli;

        $hasil = [];
        for ($i = 1; $i <= 4; $i++) {
            $hasil[$i] = $this->soalmodel
                ->getHasilPauliByUserUsed(
                    $user_id,
                    $i, // sk_group_id,
                    $materi_id,
                    1
                )
                ->getResult();
        }

        $pdf3 = new TCPDF();
        $pdf3->AddPage();
        $pdf3->SetFont('helvetica','',8);
        $pdf3->SetMargins(10, 10, 10);
        $pdf3->SetAutoPageBreak(TRUE, 10);
        $pdf3->setPrintHeader(false);
        $pdf3->setPrintFooter(false);

        $htmlPauli = '<h2 align="center" style="margin-bottom: 10px !important; padding: 0px;">PAULI</h2>
            <table border="0" width="100%" cellpadding="2">
            <tr>
                <td width="50%" valign="top">
                    <h3 align="center">Lembar 1</h3>
                    '.$this->buildTablePauli($hasil[1]).'
                </td>
                <td width="50%" valign="top">
                    <h3 align="center">Lembar 2</h3>
                    '.$this->buildTablePauli($hasil[2]).'
                </td>
            </tr>
            <tr>
                <td width="50%" valign="top">
                    <h3 align="center">Lembar 3</h3>
                    '.$this->buildTablePauli($hasil[3]).'
                </td>
                <td width="50%" valign="top">
                    <h3 align="center">Lembar 4</h3>
                    '.$this->buildTablePauli($hasil[4]).'
                </td>
            </tr>
            </table>';
        
        $pdf3->writeHTML($htmlPauli, true, false, true, false, '');

        // Halaman PDF Chart
        $pdf3->AddPage();
        $htmlChart = '
            <h2 align="center">Grafik Pauli</h2>

            <table border="0" width="100%" cellpadding="5">
                <tr>
                    <td align="center">
                        <h4>Lembar 1</h4>
                        <img src="'.$chart1File.'" height="500">
                    </td>
                    <td align="center">
                        <h4>Lembar 2</h4>
                        <img src="'.$chart2File.'" height="500">
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <h4>Lembar 3</h4>
                        <img src="'.$chart3File.'" height="500">
                    </td>
                    <td align="center">
                        <h4>Lembar 4</h4>
                        <img src="'.$chart4File.'" height="500">
                    </td>
                </tr>
            </table>
            ';

        $pdf3->writeHTML($htmlChart, true, false, true, false, '');
        $pdf3->Output($filePathPauli, 'F'); // simpan ke file

        $pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Bintang Timur Prestasi');
		$pdf->SetTitle('Hasil Tes');
		$pdf->SetSubject('Hasil Tes');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->SetImageScale(1.25); // Skala gambar
        $pdf->addPage();

        // $pdf->writeHTML($tabelHasil, true, false, true, false, '');

       
        // $filePath = WRITEPATH . 'upload/' . $filename;
        // $pdf->Output($filePath, 'F'); // simpan ke file
      
            $mailService->setTo($mhs[0]->email);
            $mailService->setFrom('admin@bintangtimurprestasi.com', 'Bintang Timur Prestasi');
            // $mailService->attach($filePath);
            $mailService->attach($filePathSalah);
            $mailService->attach($filePathPauli);
            $mailService->setSubject('Hasil Tes BTP  Psi TNI');
            $mailService->setMessage('Terima kasih telah mengikuti tryout Bintang Timur Prestasi. berikut kami kirimkan hasil anda');
            $sendit = $mailService->send();
            echo json_encode($sendit);

    }

    public function kirimemailHanyaSalah() {
        $mailService = \Config\Services::email();
        $user_id = $this->session->user_id;
        $materi_id = $this->request->getPost("materi");
        $level_id = $this->request->getPost("level_id");
        $benar = 0;
        $salah = 0;
        $nilai = 0;
        $mhs = $this->usersmodel->getbyUserId($user_id)->getResult();
        $getRespon = $this->soalmodel->getResponUntukHasil($materi_id,$level_id,$user_id)->getResult();
        
        if (count($getRespon)>0) {
            foreach ($getRespon as $key) {
                if ($key->pilihan_nm == $key->kunci) {
                    $benar = $benar + 1;
                } else {
                    $salah = $salah + 1;
                }
            }
        }
        $nilai = $benar * 2;
        
        $header = "<table border=\"0\" align=\"center\">
                        <tr><td><h1>".$mhs[0]->person_nm."</h1></td></tr>
                        <tr><td>".$getRespon[0]->materi_nm." - ".$getRespon[0]->level_nm."</td></tr>
                        <tr><td><h2>Skor Anda : $nilai</h2></td></tr>
                    </table>";

        $jumlahjawab = "<table style=\"width: 100%; margin-top:50px; margin-bottom:50px;\">
                            <tr>
                                <td width=\"150\">Jawaban Benar</td>
                                <td width=\"20\" colspan=\"2\" style=\"text-align:center;\">:</td>
                                <td width=\"50\" style=\"text-align:center;\"><label>$benar</label></td>
                            </tr>
                            <tr>
                                <td width=\"150\">Jawaban Salah</td>
                                <td width=\"20\" style=\"text-align:center;\">:</td>
                                <td width=\"50\" style=\"text-align:center;\"><label>$salah</label></td>
                            </tr>
                    </table>";

        $filename = str_replace(" ", "_", $mhs[0]->person_nm)."_".$getRespon[0]->materi_nm."_".str_replace(" ","_",$getRespon[0]->level_nm).".pdf";
        $html = view('admin/hasilpdf',[
			
		]);

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Bintang Timur Prestasi');
		$pdf->SetTitle('Hasil Tes');
		$pdf->SetSubject('Hasil Tes');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->SetImageScale(1.25); // Skala gambar
        $pdf->addPage();

        // output the HTML content
        // $pdf->IncludeJS($js);
		$pdf->writeHTML($header, true, false, true, false, '');
        $pdf->SetMargins(10, 10, 10);
		$pdf->writeHTML($jumlahjawab, true, false, true, false, '');
        $pdf->SetMargins(10, 10, 10);
        
        if (count($getRespon)>0) {
            foreach ($getRespon as $key) {
                if ($key->pembahasan_img == null || $key->pembahasan_img == "") {
                    $pembahasan_img = "";
                } else {
                    $pembahasan_img = "<img style=\"padding: 5px; margin: 5px; max-height: 100%; width: 250px; border: 5px solid black;\" src=\"/images/pembahasan/materi/".$key->materi."/level/".$key->level_nm."/".$key->pembahasan_img."\"/>";
                }

                if ($key->soal_img == "") {
                    $img_soal = "";
                } else {
                    $img_soal = "<img style=\"width:250px; max-height: 100%; border: 5px solid black;\" src=\"/images/soal/materi/".$key->materi."/level/".$key->level_nm."/".$key->soal_img."\" class=\"img-fluid\">";
                }

                if ($key->pilihan_nm != $key->kunci) {
                    $soal = "<div style=\"width: 100%; margin-top: 20px;\">
                        <label style=\"margin-top:10px;\"><b>Soal No. ".$key->soal_no."</b></label><br>
                        <table border=\"0\" width=\"100%\">
                            <tr>
                                <td width=\"20%\">Pertanyaan</td>
                                <td width=\"3%\" align=\"center\">:</td>
                                <td width=\"77%\">".$key->soal_nm."
                                    $img_soal   
                                </td>
                            </tr>
                            <tr>
                                <td width=\"20%\">Jawaban</td>
                                <td width=\"3%\" align=\"center\">:</td>
                                <td width=\"77%\">".$key->pilihan_nm."</td>
                            </tr>
                            <tr>
                                <td width=\"20%\">Kunci</td>
                                <td width=\"3%\" align=\"center\">:</td>
                                <td width=\"77%\">".$key->kunci."</td>
                            </tr>
                            <tr>
                                <td width=\"20%\">Pembahasan</td>
                                <td width=\"3%\" align=\"center\">:</td>
                                <td width=\"77%\">".strip_tags($key->pembahasan_nm)." <br>
                                    ".$pembahasan_img."
                                </td>
                            </tr>
                        </table>   
                        </div>";
                    
                    $pdf->writeHTML('<hr>', true, false, true, false, '');
                    $pdf->writeHTML($soal, true, false, true, false, '');
                } 
            }
        }

        // $pdf->IncludeJS($js);
		//line ini penting
		$this->response->setContentType('application/pdf');
		//Close and output PDF document
		$pdf->Output("/home/bint9971/public_html/akm.bintangtimurprestasi.com/akademik/writable/upload/".$filename, 'F');
        // echo json_encode($dlfile);exit;
        
        
        $mailService->setTo($mhs[0]->email);
            $mailService->setFrom('admin@bintangtimurprestasi.com', 'Hasil Try Out');
            $mailService->attach("/home/bint9971/public_html/akm.bintangtimurprestasi.com/akademik/writable/upload/".$filename);
            $mailService->setSubject('Hasil Try Out');
            $mailService->setMessage('Terima kasih telah mengikuti tryout Bintang Timur Prestasi. berikut kami kirimkan hasil try out anda');
            $sendit = $mailService->send();
            echo json_encode($sendit);

    }

}