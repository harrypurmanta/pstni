<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Soalmodel;
use App\Models\Jawabanmodel;
class Soal extends BaseController
{
    protected $soalmodel;
    protected $jawabanmodel;
    protected $session;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->soalmodel = new Soalmodel();
        $this->jawabanmodel = new Jawabanmodel();
	}


    public function index()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'group' => $this->soalmodel->getGroup()->getResult()
            ];

            return view('admin/soal/soal',$data);
        }
    }

    public function soalsikapkerja()
    {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'group' => $this->soalmodel->getGroup()->getResult()
            ];
            return view('admin/soalsikapkerja/soal',$data);
        }
    }

    public function viewTambahsoal() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {

            if ($this->session->materi_id_sess == "") {
                $materi_id = 1;
            } else {
                $materi_id = $this->session->materi_id_sess;
            }
    
            if ($this->session->group_id_sess == "") {
                $group_id = 1;
            } else {
                $group_id = $this->session->group_id_sess;
            }

            $data = [
                'no_soal' => $this->soalmodel->getNoSoal($materi_id,$group_id)->getResult(),
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'group' => $this->soalmodel->getGroup()->getResult()
            ];
            return view('admin/soal/tambahsoal',$data);
        }
    }

    public function viewEditsoal() {
        $soal_id = $this->request->getUri()->getSegment(4);
        $no_soal = $this->request->getUri()->getSegment(5);
        $group_id = $this->session->group_id = $this->request->getUri()->getSegment(6);
        $materi_id = $this->session->materi_id = $this->request->getUri()->getSegment(7);

        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {

            $getSoal = $this->soalmodel->getSoalByNoSoalGrpMtri($no_soal, $group_id, $materi_id)->getResult();
            if (count($getSoal) > 0) {
                $soal_id_new = $getSoal[0]->soal_id;
            } else {
                $soal_id_new = $soal_id;
                $getSoal = $this->soalmodel->getSoalByid($soal_id_new)->getResult();
            }

            $data = [
                'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
                'group' => $this->soalmodel->getGroup()->getResult(),
                'soal' => $getSoal,
                'jawaban' => $this->jawabanmodel->getJawabanBySoalId($soal_id_new)->getResult(),
                'soal_id' => $soal_id_new
            ];
            
            // echo json_encode($data);exit;
            return view('admin/soal/editsoal',$data);
        }
    }

    public function viewEditsoalSK() {
        $kolom_id = $this->request->getUri()->getSegment(4);
        $group_id = $this->request->getUri()->getSegment( 5);
        $materi_id = $this->request->getUri()->getSegment(6);

        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            
            $getSoal = $this->soalmodel->getSoalByIdSK($kolom_id, $group_id, $materi_id)->getResult();
            if (count($getSoal) > 0) {
                $soal_id_new = $getSoal[0]->soal_id;
            } else {
                $soal_id_new = NULL;
            }

            $total = count($getSoal);
            $size  = ceil($total / 4); // ukuran per bagian

            $bagian1 = array_slice($getSoal, 0, $size);
            $bagian2 = array_slice($getSoal, $size, $size);
            $bagian3 = array_slice($getSoal, $size * 2, $size);
            $bagian4 = array_slice($getSoal, $size * 3);

            $data = [
                'kolom' => $this->soalmodel->getKolomById($kolom_id)->getResult(),
                'bagian1' => $bagian1,
                'bagian2' => $bagian2,
                'bagian3' => $bagian3,
                'bagian4' => $bagian4,
                'jawaban' => $this->jawabanmodel->getJawabanBySoalId($soal_id_new)->getResult(),
                'soal_id' => $soal_id_new,
                "materi_id" => $materi_id
            ];
            
            
            return view('admin/soal/editsoalskmateri',$data);
        }
    }

    public function getNoSoal() {
        $group_id       = $this->request->getPost('group_id');
        $materi_id      = $this->request->getPost('materi_id');
        $no_soal = 1;
        if (isset($group_id) && isset($materi_id)) {
            $res_soal = $this->soalmodel->getNoSoal($materi_id, $group_id)->getResult();
            if ($res_soal[0]->no_soal == null) {
                $no_soal = 1;
            } else {
                $no_soal = $res_soal[0]->no_soal + 1;
            }
        } 
        echo json_encode($no_soal);
    }
    

    public function showsoal() {
        $group_id   = $this->request->getPost('group_id');
        $materi_id  = $this->request->getPost('materi_id');
        $this->session->set("group_id_sess",$group_id);
        $this->session->set("materi_id_sess",$materi_id);
        if ($group_id == 10) {
            $res    = $this->soalmodel->getKolomSoalAdmin()->getResult();
        } else {
            $res    = $this->soalmodel->getSoalBygrmt($group_id, $materi_id)->getResult();
        }
        
        echo json_encode($res);
    }

    public function hapusgambar() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $data = [
            "jawaban_img" => NULL
        ];
        $update = $this->jawabanmodel->hapusgambar($jawaban_id);
        if ($update) {
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function hapusgambarsoal() {
        $soal_id = $this->request->getPost('soal_id');
        $data = [
            "soal_img" => NULL
        ];
        $update = $this->soalmodel->hapusgambarsoal($soal_id);
        if ($update) {
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function hapusgambarpembsoal() {
        $soal_id = $this->request->getPost('soal_id');
        $data = [
            "pembahasan_img" => NULL
        ];
        $update = $this->soalmodel->hapusgambarpembsoal($soal_id);
        if ($update) {
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function simpansoal() {
        $soal_nm = $this->request->getPost('soal_nm');
        $materi_id = $this->request->getPost('materi_id');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $pembahasan_nm = $this->request->getPost('pembahasan_nm');

        $jawaban_nm_A = $this->request->getPost('jawaban_nm_A');
        $jawaban_nm_B = $this->request->getPost('jawaban_nm_B');
        $jawaban_nm_C = $this->request->getPost('jawaban_nm_C');
        $jawaban_nm_D = $this->request->getPost('jawaban_nm_D');
        $jawaban_nm_E = $this->request->getPost('jawaban_nm_E');

        $this->session->set("group_id_sess",$group_id);
        $this->session->set("materi_id_sess",$materi_id);

        $checkNoSoal = $this->soalmodel->checkNoSoalExist(0, $no_soal, $group_id, $materi_id)->getResult();
        if (count($checkNoSoal) > 0) {
            echo json_encode("exist");
            exit;
        }
        $imagefile = $this->request->getFiles();

        $pathPembahasan = FCPATH . "images/pembahasan/$materi_id/group/$group_id";
        $pathSoal = FCPATH . "images/soal/materi/$materi_id/group/$group_id";
        $pathSoalBesar = FCPATH . "images/soal/materi/$materi_id/group/$group_id/besar";

        // buat folder jika belum ada
        if (!is_dir($pathSoal)) {
            mkdir($pathSoal, 0777, true);
        }

        if (!is_dir($pathSoalBesar)) {
            mkdir($pathSoalBesar, 0777, true);
        }

        $newName = "";
        $pembahasan_img = "";
        if (isset($imagefile['soal_img'])) {
            foreach($imagefile['soal_img'] as $img){
               if ($img->isValid() && ! $img->hasMoved()){
                    $originalName = $img->getClientName();
                    $img->move($pathSoal, $originalName);
                    $newName = $img->getName();
                    copy("$pathSoal/$newName", "$pathSoalBesar/$newName");
                   }
             }
        }

        if (isset($imagefile['pembahasan_img'])) {
             foreach($imagefile['pembahasan_img'] as $imgs){
                if ($imgs->isValid() && ! $imgs->hasMoved()){
                     $pembahasan_original = $imgs->getClientName();
                     $imgs->move($pathPembahasan, $pembahasan_original);
                     $pembahasan_img = $imgs->getName();
                    }
              }
        }

        if (isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                // 'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                // 'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        }

        $pathJawaban = FCPATH . "images/jawaban/materi/$materi_id/group/$group_id";

        if (!is_dir($pathJawaban)) {
            mkdir($pathJawaban, 0777, true);
        }
      
        $soal_id = $this->soalmodel->simpansoal($data);
        if ($soal_id) {
            if (isset($imagefile['jawaban_img_A'])) {
                $imgA = $imagefile['jawaban_img_A'][0];
                if ($imgA->isValid() && ! $imgA->hasMoved()){
                     $jawaban_img_A = $imgA->getClientName();
                     $imgA->move($pathJawaban, $jawaban_img_A);
                 }
                 $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'jawaban_img' => $jawaban_img_A,
                    'status_cd' => 'normal'
                ];
            } else {
                $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'status_cd' => 'normal'
                ];
            }
            $simpanA = $this->jawabanmodel->simpanjawaban($dataA);

            if ($simpanA) {
                if (isset($imagefile['jawaban_img_B'])) {
                    $imgB = $imagefile['jawaban_img_B'][0];
                    if ($imgB->isValid() && ! $imgB->hasMoved()){
                         $jawaban_img_B = $imgB->getClientName();
                         $imgB->move($pathJawaban, $jawaban_img_B);
                     }
                     $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'jawaban_img' => $jawaban_img_B,
                        'status_cd' => 'normal'
                    ];
                } else {
                    $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'status_cd' => 'normal'
                    ];
                }
                
                $simpanB = $this->jawabanmodel->simpanjawaban($dataB);
                if ($simpanB) {
                    if (isset($imagefile['jawaban_img_C'])) {
                        $imgC = $imagefile['jawaban_img_C'][0];
                        if ($imgC->isValid() && ! $imgC->hasMoved()){
                             $jawaban_img_C = $imgC->getClientName();
                             $imgC->move($pathJawaban, $jawaban_img_C);
                         }
                         $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'jawaban_img' => $jawaban_img_C,
                            'status_cd' => 'normal'
                        ];
                    } else {
                        $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'status_cd' => 'normal'
                        ];
                    }

                    $simpanC = $this->jawabanmodel->simpanjawaban($dataC);
                    if ($simpanC) {
                        if (isset($imagefile['jawaban_img_D'])) {
                            $imgD = $imagefile['jawaban_img_D'][0];
                            if ($imgD->isValid() && ! $imgD->hasMoved()){
                                 $jawaban_img_D = $imgD->getClientName();
                                 $imgD->move($pathJawaban, $jawaban_img_D);
                             }
                             $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'jawaban_img' => $jawaban_img_D,
                                'status_cd' => 'normal'
                            ];
                        } else {
                            $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'status_cd' => 'normal'
                            ];
                        }
                        
                        

                        $simpanD = $this->jawabanmodel->simpanjawaban($dataD);
                        if ($simpanD) {
                            if (isset($imagefile['jawaban_img_E'])) {
                                $imgE = $imagefile['jawaban_img_E'][0];
                                if ($imgE->isValid() && ! $imgE->hasMoved()){
                                     $jawaban_img_E = $imgE->getClientName();
                                     $imgE->move($pathJawaban, $jawaban_img_E);
                                 }
                                 $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'jawaban_img' => $jawaban_img_E,
                                    'status_cd' => 'normal'
                                ];
                                $simpanE = $this->jawabanmodel->simpanjawaban($dataE);
                                if ($simpanE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else if ($jawaban_nm_E != "") {
                                $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'status_cd' => 'normal'
                                ];
                                $simpanE = $this->jawabanmodel->simpanjawaban($dataE);
                                if ($simpanE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else {
                                $ret = "berhasil";
                            }

                        } else {
                            $ret = "gagalD";
                        }
                        
                    } else {
                        $ret = "gagaC";
                    }
                    
                } else {
                    $ret = "gagalB";
                }
                
            } else {
                $ret = "gagalA";
            }

        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
        // echo json_encode($group[0]->group_nm);
    }

    public function updatesoal() {
        $soal_id = $this->request->getPost('soal_id');
        $soal_nm = $this->request->getPost('soal_nm');
        $materi_id = $this->request->getPost('materi_id');
        $kunci = $this->request->getPost('kunci');
        $group_id = $this->request->getPost('group_id');
        $no_soal = $this->request->getPost('no_soal');
        $pembahasan_nm = $this->request->getPost('pembahasan_nm');

        $oldSoal = $this->soalmodel->getSoalByid($soal_id)->getRow();

        $checkNoSoal = $this->soalmodel->checkNoSoalExist($soal_id, $no_soal, $group_id, $materi_id)->getResult();
        if (count($checkNoSoal) > 0) {
            $ret = json_encode(["respon" => "exist"]);
            return $ret;
        }

        $jawaban_id_A = $this->request->getPost('jawaban_id_A');
        $jawaban_id_B = $this->request->getPost('jawaban_id_B');
        $jawaban_id_C = $this->request->getPost('jawaban_id_C');
        $jawaban_id_D = $this->request->getPost('jawaban_id_D');
        $jawaban_id_E = $this->request->getPost('jawaban_id_E');

        $jawaban_nm_A = $this->request->getPost('jawaban_nm_A');
        $jawaban_nm_B = $this->request->getPost('jawaban_nm_B');
        $jawaban_nm_C = $this->request->getPost('jawaban_nm_C');
        $jawaban_nm_D = $this->request->getPost('jawaban_nm_D');
        $jawaban_nm_E = $this->request->getPost('jawaban_nm_E');

        $this->session->set("group_id",$group_id);
        $this->session->set("materi_id",$materi_id);
        $imagefile = $this->request->getFiles();

        $newName = "";
        $pembahasan_img = "";
        if (isset($imagefile['soal_img'])) {
            foreach($imagefile['soal_img'] as $img){
               if ($img->isValid() && ! $img->hasMoved()){
                    // Delete old question image if it exists
                    if ($oldSoal && !empty($oldSoal->soal_img)) {
                        $oldSoalImgPath = FCPATH . "images/soal/materi/{$oldSoal->materi}/group/{$oldSoal->group_id}/{$oldSoal->soal_img}";
                        $oldSoalImgBesarPath = FCPATH . "images/soal/materi/{$oldSoal->materi}/group/{$oldSoal->group_id}/besar/{$oldSoal->soal_img}";
                        if (is_file($oldSoalImgPath)) {
                            unlink($oldSoalImgPath);
                        }
                        if (is_file($oldSoalImgBesarPath)) {
                            unlink($oldSoalImgBesarPath);
                        }
                    }

                    $originalName = $img->getClientName();
                    $targetDir = FCPATH . "images/soal/materi/$materi_id/group/$group_id";
                    $besarDir = "$targetDir/besar";
                    if (!is_dir($besarDir)) {
                        mkdir($besarDir, 0777, true);
                    }
                    $img->move($targetDir, $originalName);
                    $newName = $img->getName();
                    copy("$targetDir/$newName", "$besarDir/$newName");
                   }
             }
        }

        if (isset($imagefile['pembahasan_img'])) {
             foreach($imagefile['pembahasan_img'] as $imgs){
                if ($imgs->isValid() && ! $imgs->hasMoved()){
                     // Delete old pembahasan image if it exists
                     if ($oldSoal && !empty($oldSoal->pembahasan_img)) {
                         $oldPembahasanPath = FCPATH . "images/pembahasan/{$oldSoal->materi}/{$oldSoal->pembahasan_img}";
                         if (is_file($oldPembahasanPath)) {
                             unlink($oldPembahasanPath);
                         }
                     }

                     $pembahasan_original = $imgs->getClientName();
                     $targetPembahasan = FCPATH . "images/pembahasan/$materi_id";
                     if (!is_dir($targetPembahasan)) {
                         mkdir($targetPembahasan, 0777, true);
                     }
                     $imgs->move($targetPembahasan, $pembahasan_original);
                     $pembahasan_img = $imgs->getName();
                    }
              }
        }

        if (isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                // 'soal_img' => $newName,
                'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        } else if (!isset($imagefile['pembahasan_img']) && !isset($imagefile['soal_img'])) {
            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no_soal,
                'kunci' => $kunci,
                'materi' => $materi_id,
                // 'soal_img' => $newName,
                // 'pembahasan_img' => $pembahasan_img,
                'pembahasan' => $pembahasan_nm,
                'status_cd' => 'normal'
            ];
        }

      
        $updatesoal = $this->soalmodel->updatesoal($soal_id, $data);

        if ($updatesoal) {
            $targetPathJwb = FCPATH . "images/jawaban/materi/$materi_id/group/$group_id";
            if (!is_dir($targetPathJwb)) {
                mkdir($targetPathJwb, 0777, true);
            }

            if (isset($imagefile['jawaban_img_A'])) {
                $imgA = $imagefile['jawaban_img_A'][0];
                if ($imgA->isValid() && ! $imgA->hasMoved()){
                     $jawaban_img_A = $imgA->getClientName();
                     $imgA->move($targetPathJwb, $jawaban_img_A);
                 }
                 $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'jawaban_img' => $jawaban_img_A,
                    'status_cd' => 'normal'
                ];
            } else {
                $dataA = [
                    'soal_id' => $soal_id,
                    'jawaban_nm' => $jawaban_nm_A,
                    'pilihan_nm' => "A",
                    'status_cd' => 'normal'
                ];
            }
            $updateA = $this->jawabanmodel->updatejawaban($jawaban_id_A, $dataA);

            if ($updateA) {
                if (isset($imagefile['jawaban_img_B'])) {
                    $imgB = $imagefile['jawaban_img_B'][0];
                    if ($imgB->isValid() && ! $imgB->hasMoved()){
                         $jawaban_img_B = $imgB->getClientName();
                         $imgB->move($targetPathJwb, $jawaban_img_B);
                     }
                     $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'jawaban_img' => $jawaban_img_B,
                        'status_cd' => 'normal'
                    ];
                } else {
                    $dataB = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm_B,
                        'pilihan_nm' => "B",
                        'status_cd' => 'normal'
                    ];
                }
                
                $updateB = $this->jawabanmodel->updatejawaban($jawaban_id_B, $dataB);
                if ($updateB) {
                    if (isset($imagefile['jawaban_img_C'])) {
                        $imgC = $imagefile['jawaban_img_C'][0];
                        if ($imgC->isValid() && ! $imgC->hasMoved()){
                             $jawaban_img_C = $imgC->getClientName();
                             $imgC->move($targetPathJwb, $jawaban_img_C);
                         }
                         $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'jawaban_img' => $jawaban_img_C,
                            'status_cd' => 'normal'
                        ];
                    } else {
                        $dataC = [
                            'soal_id' => $soal_id,
                            'jawaban_nm' => $jawaban_nm_C,
                            'pilihan_nm' => "C",
                            'status_cd' => 'normal'
                        ];
                    }

                    $updateC = $this->jawabanmodel->updatejawaban($jawaban_id_C, $dataC);
                    if ($updateC) {
                        if (isset($imagefile['jawaban_img_D'])) {
                            $imgD = $imagefile['jawaban_img_D'][0];
                            if ($imgD->isValid() && ! $imgD->hasMoved()){
                                 $jawaban_img_D = $imgD->getClientName();
                                 $imgD->move($targetPathJwb, $jawaban_img_D);
                             }
                             $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'jawaban_img' => $jawaban_img_D,
                                'status_cd' => 'normal'
                            ];
                        } else {
                            $dataD = [
                                'soal_id' => $soal_id,
                                'jawaban_nm' => $jawaban_nm_D,
                                'pilihan_nm' => "D",
                                'status_cd' => 'normal'
                            ];
                        }
                        
                        

                        $updateD = $this->jawabanmodel->updatejawaban($jawaban_id_D, $dataD);
                        if ($updateD) {
                            if (isset($imagefile['jawaban_img_E'])) {
                                $imgE = $imagefile['jawaban_img_E'][0];
                                if ($imgE->isValid() && ! $imgE->hasMoved()){
                                     $jawaban_img_E = $imgE->getClientName();
                                     $imgE->move($targetPathJwb, $jawaban_img_E);
                                 }
                                 $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'jawaban_img' => $jawaban_img_E,
                                    'status_cd' => 'normal'
                                ];
                                $updateE = $this->jawabanmodel->updatejawaban($jawaban_id_E, $dataE);
                                if ($updateE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else if ($jawaban_nm_E != "") {
                                $dataE = [
                                    'soal_id' => $soal_id,
                                    'jawaban_nm' => $jawaban_nm_E,
                                    'pilihan_nm' => "E",
                                    'status_cd' => 'normal'
                                ];
                                $updateE = $this->jawabanmodel->updatejawaban($jawaban_id_E, $dataE);
                                if ($updateE) {
                                    $ret = "berhasil";
                                } else {
                                    $ret = "gagalE";
                                }
                            } else {
                                $ret = "berhasil";
                            }

                        } else {
                            $ret = "gagalD";
                        }
                        
                    } else {
                        $ret = "gagaC";
                    }
                    
                } else {
                    $ret = "gagalB";
                }
                
            } else {
                $ret = "gagalA";
            }

        } else {
            $ret = "gagal";
        }

        if ($ret == "berhasil") {
            $no_soal_new = $no_soal + 1;
            $getSoal = $this->soalmodel->getSoalByNoSoalGrpMtri($no_soal_new, $group_id, $materi_id)->getResult();
            if (count($getSoal) > 0) {
                $soal_id_new = $getSoal[0]->soal_id;
            } else {
                $soal_id_new = $soal_id;
                $no_soal_new = $no_soal;
            }
            $ret = [
                "respon" => "berhasil",
                "soal_id" => $soal_id_new,
                "no_soal" => $no_soal_new
            ];
        }

        echo json_encode($ret);
    }

    public function updateclue() {
        if ($this->session->get("user_nm") == "") {
			return view('login');
		} 

        $group_id = 4;
        $materi_id = $this->request->getPost('materi_id');
        $sk_group_id = 0;
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $jawaban_nm_lama = $this->request->getPost('jawaban_nm_lama');
        $kolom_id = $this->request->getPost('kolom_id');
        
        if ($this->request->getPost('jawaban_nm_lama') == $this->request->getPost('jawaban_nm')) {
            $res = "finish";
        } else {
            $soal_id = $this->soalmodel->getSoalIdByClue($jawaban_nm_lama, $group_id, $sk_group_id, $kolom_id)->getResult();
            $res = $this->randomcharUpdate($jawaban_nm, $kolom_id,$materi_id,$sk_group_id,$group_id, $soal_id, $jawaban_nm_lama);
        }
        
        echo json_encode($res);
    }

    public function updatesoalskmateri() {
        $soal_id = $this->request->getPost('soal_id');
        $soal_nm = $this->request->getPost('soal_nm');

        $data = [
            "soal_nm" => $soal_nm
        ];

        $updatesoal = $this->soalmodel->updatesoal($soal_id, $data);
        if ($updatesoal) {
            $ret = "berhasil";
        } else {
            $ret = "gagal";
        }
        echo json_encode($ret);
    }

    public function hapussoal() {
        $soal_id = $this->request->getPost('soal_id');
        $data = [
            'status_cd' => 'nullified'
        ];
        $this->soalmodel->hapussoal($soal_id,$data);
        // echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        echo json_encode("sukses");
    }

    public function showjawaban() {
        $soal_id = $this->request->getPost('soal_id');
        $res = $this->soalmodel->getJawabanBysoalId($soal_id)->getResult();
        $cntform = 1;
        if (count($res)>0) {
            $ret = "<td class='td_form' colspan='2'></td>
                        <td colspan='4' class='td_form'>
                        <table id='tb_jawaban${soal_id}' class='table table-bordered table-hover'>
                        <tbody>";
                        foreach ($res as $key) {
                            $jawaban_id = $key->jawaban_id;
                            $ret .= "<tr id='tr_form_${soal_id}_${jawaban_id}'>
                                      <td style='text-align:center;width:50px;'><button onclick='timesbtn($soal_id,$jawaban_id)' type='button' class='btn btn-outline-danger'><i class='fa fa-times'></i></button></td>
                                      <td style='text-align:center;width:50px;'><input style='width:50px;text-align:center;' type='text' value='".$key->pilihan_nm."' id='pilihan_nm_${jawaban_id}' name='pilihan_nm[]' data-id='$jawaban_id'/> </td>
                                      <td><input style='padding-left:10px;width:100%;' type='text' value='".$key->jawaban_nm."' id='jawaban_nm_${jawaban_id}' name='jawaban_nm[]'/> </td>
                                      <td style='text-align:center;width:50px;'>
                                      <button onclick='deletebtn($soal_id,$jawaban_id)' type='button' class='btn btn-outline-danger'><i class='fa fa-trash'></i></button>
                                      </td>
                                      <td style='text-align:center;'>";
                                $ret .= "<div><input type='file' id='jawaban_img_${jawaban_id}' name='jawaban_img[]' data-jawaban_id='$jawaban_id' style='max-width: 200px;'/> <button onclick='hapusgambarjawaban($jawaban_id)' type='button' class='btn btn-outline-danger'><i class='fa fa-trash'></i></button> <button onclick='simpangambarjawaban($soal_id,$jawaban_id)' type='button' class='btn btn-outline-success'><i class='fa  fa-save'></i></button></div>";
                                    if ($key->jawaban_img == "") {
                                        $ret .= "";
                                    } else {
                                        $ret .= "<div><img style='max-width:150px;heigth:100%;' src='".base_url()."/images/jawaban/materi/".$this->session->materi_filter."/".$key->jawaban_img.".jpg'></div>";
                                    }
                                $ret .= "</td>
                                     </tr>";
                        }
            $ret .= "</tbody>
                    </table>
                    </td>
                    <td class='td_form' colspan='4' style='line-height: 10;'>
                    <button onclick='plusbtn($soal_id)' type='button' class='btn btn-outline-primary'><i class='fa fa-plus'></i></button>
                   
                    <button onclick='checkbtn($soal_id)' type='button' class='btn btn-outline-success'><i class='fa fa-check'></i></button>
                    </td>";
                    
        } else {
            $ret = "<td class='td_form' colspan='2'></td>
                        <td class='td_form'>
                        <table id='tb_jawaban${soal_id}' class='table table-bordered table-hover'>
                        <tbody>";
                $ret .= "<tr class='tr_form' id='tr_form_${soal_id}_${cntform}'>
                            <td style='text-align:center;width:50px;'><button onclick='timesbtn($soal_id,$cntform)' type='button' class='btn btn-outline-danger'><i class='fa fa-times'></i></button></td>
                            <td style='text-align:center;width:50px;'><input style='width:50px;text-align:center;' type='text' value='' name='pilihan_nm[]' data-id='new'/> </td>
                            <td><input style='padding-left:10px;width:100%;' type='text' value='' name='jawaban_nm[]'/> </td>
                        </tr>";
            $ret .= "</tbody>
                    </table>
                    </td>
                    <td class='td_form' colspan='4' style='line-height: 10;'>
                    <button onclick='plusbtn($soal_id)' type='button' class='btn btn-outline-primary'><i class='fa fa-plus'></i></button>
                   
                    <button onclick='checkbtn($soal_id)' type='button' class='btn btn-outline-success'><i class='fa fa-check'></i></button>
                    </td>";
        }
        echo json_encode($ret);
    }

    public function simpanjawaban() {
        $soal_id    = $this->request->getPost('soal_id');
        $pilihan_nm = $this->request->getPost('pilihan_nm');
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $jawaban_id = $this->request->getPost('jawaban_id');
        $i = 0;
        foreach ($pilihan_nm as $k => $v) {
            $imagefile = $this->request->getFiles();
        
            if ($v['id'] == "new") {
                if ($imagefile["jawaban_img"][$i]->isValid() && ! $imagefile["jawaban_img"][$i]->hasMoved()){
                    $newName = $soal_id.$pilihan_nm[$i];
                    $targetDir = FCPATH . "images/materi/".$this->session->materi_filter."/";
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }
                    $imagefile["jawaban_img"][$i]->move($targetDir, $newName);
                }

                $data = [
                    "soal_id" => $soal_id,
                    "pilihan_nm" => $v['value'],
                    "jawaban_nm" => $jawaban_nm[$i],
                    "jawaban_img" => $newName,
                    "status_cd" => "normal"
                ];
                $simpanjawaban = $this->soalmodel->simpanjawaban($data);
            } else {
                $data = [
                    "soal_id" => $soal_id,
                    "pilihan_nm" => $v['value'],
                    "jawaban_nm" => $jawaban_nm[$i],
                    "jawaban_img" => $newName,
                    "status_cd" => "normal"
                ];
                $simpanjawaban = $this->soalmodel->updatejawaban($jawaban_id[$i],$data);
            }
            $i++;
        }

        if ($simpanjawaban) {
            echo json_encode("sukses");
        }
    }

    public function deletejawaban() {
        $jawaban_id = $this->request->getPost('jawaban_id');
        $deletejawaban = $this->soalmodel->deletejawaban($jawaban_id);
        if ($deletejawaban) {
            echo json_encode("sukses");
        } else {
            echo json_encode("gagal");
        }
    }

    public function tambahsoallatihan() {
        $materi_id = "";
        $ret = "<div class='card'>
                <div class='card-body'>
                <div class='row'>
                <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>
                    <div style='margin-bottom:20px;' class='col-lg-12'><label for='no_soal'>Materi : </label>";

                    $allmateri = $this->soalmodel->getAllJMateri()->getResult();
                        foreach ($allmateri as $mat) {
                            $materi_id = $mat->materi_id;
                            $ret .= "<label style='margin:0px 10px;' for='materix_${materi_id}'><input value='".$mat->materi_id."' type='radio' id='materix_${materi_id}' name='materix' ".($materi_id==$this->session->materi?'checked':'')."/> ".$mat->materi_nm."</label>";
                        }
                    $ret .= "</div>
                    <div class='form-group row'>
                        <label for='kolom1' class='col-form-label'>Kolom 1 </label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom1\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom1' name='kolom1'>
                        </div>

                        <label for='kolom2' class='col-form-label'>Kolom 2</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom2\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom2' name='kolom2'>
                        </div>

                        <label for='kolom3' class='col-form-label'>Kolom 3</label>
                        <div class='col-2' style=\"margin-left:5px;\">
                        <input onkeyup='checkdupe(\"kolom3\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom3' name='kolom3'>
                        </div>
                    </div>

                    <div class='form-group row'>
                        <label for='kolom4' class='col-form-label'>Kolom 4</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom4\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom4' name='kolom4'>
                        </div>

                        <label for='kolom5' class='col-form-label'>Kolom 5</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom5\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom5' name='kolom5'>
                        </div>

                        <label for='kolom6' class='col-form-label'>Kolom 6</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom6\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom6' name='kolom6'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='kolom7' class='col-form-label'>Kolom 7</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom7\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom7' name='kolom7'>
                        </div>

                        <label for='kolom8' class='col-form-label'>Kolom 8</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom8\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom8' name='kolom8'>
                        </div>

                        <label for='kolom9' class='col-form-label'>Kolom 9</label>
                        <div class='col-2' style=\"margin-left:5px;\">
                        <input onkeyup='checkdupe(\"kolom9\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom9' name='kolom9'>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <label for='kolom10' class='col-form-label'>Kolom 10</label>
                        <div class='col-2' style=\"margin-left:5px;margin-right:10px;\">
                        <input onkeyup='checkdupe(\"kolom10\")' oninput='this.value = this.value.toUpperCase()' maxlength='5' type='text' class='form-control' id='kolom10' name='kolom10'>
                        </div>
                    </div>
                  
                    </div>
                    <div class='card-footer'>
                    <button onclick='simpansoallatihan()' type='button' class='btn btn-info'>Simpan</button>
                    <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>";
                    
        $ret .= "</div>
                </div>
                </div>
                </div>
                </div>";

        return $ret;
    }

    public function simpansoallatihan() {
        $materi_id = $this->request->getPost('materi_id');
        $kolom1 = $this->request->getPost('kolom1');
        $kolom2 = $this->request->getPost('kolom2');
        $kolom3 = $this->request->getPost('kolom3');
        $kolom4 = $this->request->getPost('kolom4');
        $kolom5 = $this->request->getPost('kolom5');
        $kolom6 = $this->request->getPost('kolom6');
        $kolom7 = $this->request->getPost('kolom7');
        $kolom8 = $this->request->getPost('kolom8');
        $kolom9 = $this->request->getPost('kolom9');
        $kolom10 = $this->request->getPost('kolom10');
        $sk_group_id = 1;
        $res_sk_group = $this->soalmodel->getSKgroup()->getResult();
        if (count($res_sk_group)>0) {
            $sk_num = mb_substr($res_sk_group[0]->sk_group_nm, -1);
            $num = $sk_num + 1;
            $data = [
                "sk_group_nm" => "Sikap Kerja ".$num
            ];

            $sk_group_id = $this->soalmodel->insertSKgroup($data);
        } else {
            $data = [
                "sk_group_nm" => "Sikap Kerja 1"
            ];

            $sk_group_id = $this->soalmodel->insertSKgroup($data);
        }
        


        $res = $this->randomchar($kolom1,1,$materi_id,$sk_group_id);
        // log_message("info",$res);
        if ($res == "finish") {
            $res = $this->randomchar($kolom2,2,$materi_id,$sk_group_id);
            if ($res == "finish") {
                $res = $this->randomchar($kolom3,3,$materi_id,$sk_group_id);
                if ($res == "finish") {
                    $res = $this->randomchar($kolom4,4,$materi_id,$sk_group_id);
                    if ($res == "finish") {
                        $res = $this->randomchar($kolom5,5,$materi_id,$sk_group_id);
                        if ($res == "finish") {
                            $res = $this->randomchar($kolom6,6,$materi_id,$sk_group_id);
                            if ($res == "finish") {
                                $res = $this->randomchar($kolom7,7,$materi_id,$sk_group_id);
                                if ($res == "finish") {
                                    $res = $this->randomchar($kolom8,8,$materi_id,$sk_group_id);
                                    if ($res == "finish") {
                                        $res = $this->randomchar($kolom9,9,$materi_id,$sk_group_id);
                                        if ($res == "finish") {
                                            $res = $this->randomchar($kolom10,10,$materi_id,$sk_group_id);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } 
        
        echo json_encode("sukses");
    }

    public function randomcharUpdate($char,$kolom,$materi_id,$sk_group_id,$group_id,$soal_id,$jawaban_nm_lama) {
        // echo json_encode($soal_id);exit;
        $characters = $char; 
        $pilihan = "ABCDE";
        $kunci = "";
        $no = 1;
        $index = 0;
        for ($i = 0; $i < 50; $i++) {
            $indexs = rand(0, strlen($pilihan) - 1);
            $kunci = $pilihan[$indexs];
            if ($kunci == "A") {
                $hilang = $characters[0];
            } else if ($kunci == "B") {
                $hilang = $characters[1];
            } else if ($kunci == "C") {
                $hilang = $characters[2];
            } else if ($kunci == "D") {
                $hilang = $characters[3];
            } else if ($kunci == "E") {
                $hilang = $characters[4];
            }
            
            $soal_txt = $this->randsoal($characters,"");
           
            if (strlen($soal_txt) === 5) {
                $soal_nm = str_replace($hilang,"",$soal_txt);
            } else {
                $soal_nm = $soal_txt;
            }

            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => $group_id,
                'no_soal' => $no,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'status_cd' => 'normal',
                'kolom_id' => $kolom,
                'clue' => $characters,
                'sk_group_id' => $sk_group_id
            ];

            $updatesoal = $this->soalmodel->updatesoalsk($group_id,$sk_group_id,$kolom,$data,$soal_id[$index]->soal_id,$jawaban_nm_lama);

            if ($updatesoal) {
                $dataJawaban = [
                    "pilihan_nm" => $pilihan,
                    "jawaban_nm" => $characters,
                    "status_cd" => "normal"
                ];
    
                $updatejawaban = $this->soalmodel->updatejawabansk($characters,$dataJawaban,$soal_id[$index]->soal_id,$jawaban_nm_lama);
                if ($updatejawaban) {
                    $ret = "finish";
                } else {
                    $ret = "gagaljwb";
                }
                
            } else {
                $ret = "gagalsoal";
            }
            
            $no++;
            $index++;
        }
        return $ret;
    }
    public function randsoal($characters,$randSoal) {
        $randomString = $randSoal;
        for ($s = 0; $s < 5; $s++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        
        $randSoal = count_chars($randomString,3);
        if (strlen($randSoal) == 5) {
            $soal_nm = str_shuffle($randSoal);
        } else {
            $soal_nm = $this->randsoal($characters,$randSoal);
        }

        return $soal_nm;
    }

    public function randomchar($char,$kolom,$materi_id,$sk_group_id) {
        $characters = $char; 
        $pilihan = "ABCDE";
        $kunci = "";
        $no = 1;
        for ($i = 0; $i < 50; $i++) {
            $indexs = rand(0, strlen($pilihan) - 1);
            $kunci = $pilihan[$indexs];
            if ($kunci == "A") {
                $hilang = $characters[0];
            } else if ($kunci == "B") {
                $hilang = $characters[1];
            } else if ($kunci == "C") {
                $hilang = $characters[2];
            } else if ($kunci == "D") {
                $hilang = $characters[3];
            } else if ($kunci == "E") {
                $hilang = $characters[4];
            }
            
            $soal_txt = $this->randsoal($characters,"");
           
            if (strlen($soal_txt) === 5) {
                $soal_nm = str_replace($hilang,"",$soal_txt);
            } else {
                $soal_nm = $soal_txt;
            }

            $data = [
                'soal_nm' => $soal_nm,
                'group_id' => 4,
                'no_soal' => $no,
                'kunci' => $kunci,
                'materi' => $materi_id,
                'status_cd' => 'normal',
                'kolom_id' => $kolom,
                'clue' => $characters,
                'sk_group_id' => $sk_group_id
            ];

            $soal_id = $this->soalmodel->insertsoalSKlatihan($data);

            $datax = [
                "soal_id" => $soal_id,
                "pilihan_nm" => $pilihan,
                "jawaban_nm" => $characters,
                "jawaban_img" => "",
                "status_cd" => "normal"
            ];
    
            

            $this->soalmodel->insertjawabanSKlatihan($datax);
            $no++;
        }
        return "finish";
    }
    

    public function updatestatus() {
        $jawaban_nm = $this->request->getPost('jawaban_nm');
        $kolom_id = $this->request->getPost('kolom_id');
        $status_cd = $this->request->getPost('status_cd');
        $old_status = $this->request->getPost('old_status');

        $update = $this->soalmodel->updatestatus($jawaban_nm,$kolom_id,$status_cd,$old_status);
    }

    public function downloadTemplate()
    {
        if ($this->session->get("user_nm") == "") {
            return redirect('/');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Header
        $sheet->setCellValue('A1', 'No Soal');
        $sheet->setCellValue('B1', 'Soal');
        $sheet->setCellValue('C1', 'soal_img');
        $sheet->setCellValue('D1', 'Pilihan A');
        $sheet->setCellValue('E1', 'jawaban_img A');
        $sheet->setCellValue('F1', 'Pilihan B');
        $sheet->setCellValue('G1', 'jawaban_img B');
        $sheet->setCellValue('H1', 'Pilihan C');
        $sheet->setCellValue('I1', 'jawaban_img C');
        $sheet->setCellValue('J1', 'Pilihan D');
        $sheet->setCellValue('K1', 'jawaban_img D');
        $sheet->setCellValue('L1', 'Pilihan E');
        $sheet->setCellValue('M1', 'jawaban_img E');
        $sheet->setCellValue('N1', 'Kunci');
        $sheet->setCellValue('O1', 'Pembahasan');
        $sheet->setCellValue('P1', 'pembahasan_img');

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2E7D32'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $sheet->getStyle('A1:P1')->applyFromArray($headerStyle);

        // Auto size
        foreach (range('A', 'P') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Example row
        $sheet->setCellValue('A2', '1');
        $sheet->setCellValue('B2', 'Pertanyaan atau soal di sini.');
        $sheet->setCellValue('C2', 'soal_1.jpg');
        $sheet->setCellValue('D2', 'Jawaban Pilihan A');
        $sheet->setCellValue('E2', 'jawaban_a_1.jpg');
        $sheet->setCellValue('F2', 'Jawaban Pilihan B');
        $sheet->setCellValue('G2', 'jawaban_b_1.jpg');
        $sheet->setCellValue('H2', 'Jawaban Pilihan C');
        $sheet->setCellValue('I2', 'jawaban_c_1.jpg');
        $sheet->setCellValue('J2', 'Jawaban Pilihan D');
        $sheet->setCellValue('K2', 'jawaban_d_1.jpg');
        $sheet->setCellValue('L2', 'Jawaban Pilihan E (boleh kosong)');
        $sheet->setCellValue('M2', 'jawaban_e_1.jpg');
        $sheet->setCellValue('N2', 'A');
        $sheet->setCellValue('O2', 'Penjelasan atau pembahasan soal di sini.');
        $sheet->setCellValue('P2', 'pembahasan_1.jpg');

        $filename = 'Template_Import_Soal.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function importExcel()
    {
        if ($this->session->get("user_nm") == "") {
            return json_encode(['status' => 'error', 'message' => 'Sesi Anda telah habis. Silakan login kembali.']);
        }

        $materi_id = $this->request->getPost('materi_id');
        $group_id = $this->request->getPost('group_id');
        $file = $this->request->getFile('file_excel');

        if (!$materi_id || !$group_id) {
            return json_encode(['status' => 'error', 'message' => 'Materi dan Group Soal harus dipilih.']);
        }

        if (!$file || !$file->isValid()) {
            return json_encode(['status' => 'error', 'message' => 'File Excel tidak ditemukan atau tidak valid.']);
        }

        $ext = $file->getClientExtension();
        if (!in_array($ext, ['xls', 'xlsx'])) {
            return json_encode(['status' => 'error', 'message' => 'Format file harus berupa .xls atau .xlsx.']);
        }

        try {
            $reader = null;
            if ($ext === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
            
            if (count($rows) <= 1) {
                return json_encode(['status' => 'error', 'message' => 'File Excel kosong atau hanya berisi header.']);
            }

            if (count($rows[0]) < 16) {
                return json_encode(['status' => 'error', 'message' => 'Format kolom Excel tidak sesuai. Harus ada minimal 16 kolom. Download template excel yang baru.']);
            }

            $validatedRows = [];
            $seenNoSoal = [];

            // Validation loop
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                $isEmptyRow = true;
                foreach ($row as $cellValue) {
                    if ($cellValue !== null && trim($cellValue) !== '') {
                        $isEmptyRow = false;
                        break;
                    }
                }
                if ($isEmptyRow) {
                    continue;
                }

                $no_soal = isset($row[0]) ? trim($row[0]) : '';
                $soal_nm = isset($row[1]) ? trim($row[1]) : '';
                $soal_img = isset($row[2]) ? trim($row[2]) : '';
                
                $pilihan_a = isset($row[3]) ? trim($row[3]) : '';
                $jawaban_img_a = isset($row[4]) ? trim($row[4]) : '';
                
                $pilihan_b = isset($row[5]) ? trim($row[5]) : '';
                $jawaban_img_b = isset($row[6]) ? trim($row[6]) : '';
                
                $pilihan_c = isset($row[7]) ? trim($row[7]) : '';
                $jawaban_img_c = isset($row[8]) ? trim($row[8]) : '';
                
                $pilihan_d = isset($row[9]) ? trim($row[9]) : '';
                $jawaban_img_d = isset($row[10]) ? trim($row[10]) : '';
                
                $pilihan_e = isset($row[11]) ? trim($row[11]) : '';
                $jawaban_img_e = isset($row[12]) ? trim($row[12]) : '';
                
                $kunci = isset($row[13]) ? strtoupper(trim($row[13])) : '';
                $pembahasan = isset($row[14]) ? trim($row[14]) : '';
                $pembahasan_img = isset($row[15]) ? trim($row[15]) : '';

                $rowNum = $i + 1;

                if ($no_soal === '') {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Nomor Soal tidak boleh kosong."]);
                }
                if (!is_numeric($no_soal)) {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Nomor Soal harus berupa angka."]);
                }
                $no_soal = (int)$no_soal;

                if ($soal_nm === '' && $soal_img === '') {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Teks Soal atau Gambar Soal tidak boleh kosong."]);
                }

                if (($pilihan_a === '' && $jawaban_img_a === '') || 
                    ($pilihan_b === '' && $jawaban_img_b === '') || 
                    ($pilihan_c === '' && $jawaban_img_c === '') || 
                    ($pilihan_d === '' && $jawaban_img_d === '')) {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Pilihan A, B, C, dan D tidak boleh kosong (harus diisi teks atau nama file gambar)."]);
                }

                if (!in_array($kunci, ['A', 'B', 'C', 'D', 'E'])) {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Kunci jawaban harus berupa A, B, C, D, atau E."]);
                }

                if ($kunci === 'E' && $pilihan_e === '' && $jawaban_img_e === '') {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Kunci jawaban adalah E, tetapi pilihan E kosong."]);
                }

                if (in_array($no_soal, $seenNoSoal)) {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Nomor Soal $no_soal duplikat di dalam file Excel."]);
                }
                $seenNoSoal[] = $no_soal;

                $dbCheck = $this->soalmodel->getSoalByNoSoalGrpMtri($no_soal, $group_id, $materi_id)->getResult();
                if (count($dbCheck) > 0) {
                    return json_encode(['status' => 'error', 'message' => "Baris $rowNum: Nomor Soal $no_soal sudah terdaftar di database untuk materi dan group ini."]);
                }

                $validatedRows[] = [
                    'no_soal' => $no_soal,
                    'soal_nm' => $soal_nm,
                    'soal_img' => $soal_img,
                    'options' => [
                        'A' => ['text' => $pilihan_a, 'img' => $jawaban_img_a],
                        'B' => ['text' => $pilihan_b, 'img' => $jawaban_img_b],
                        'C' => ['text' => $pilihan_c, 'img' => $jawaban_img_c],
                        'D' => ['text' => $pilihan_d, 'img' => $jawaban_img_d],
                        'E' => ['text' => $pilihan_e, 'img' => $jawaban_img_e]
                    ],
                    'kunci' => $kunci,
                    'pembahasan' => $pembahasan,
                    'pembahasan_img' => $pembahasan_img
                ];
            }

            if (empty($validatedRows)) {
                return json_encode(['status' => 'error', 'message' => 'Tidak ada data soal yang valid ditemukan di dalam file Excel.']);
            }

            $db = \Config\Database::connect();
            $db->transBegin();

            $successCount = 0;
            foreach ($validatedRows as $vRow) {
                $soalData = [
                    'soal_nm' => $vRow['soal_nm'],
                    'group_id' => $group_id,
                    'no_soal' => $vRow['no_soal'],
                    'kunci' => $vRow['kunci'],
                    'materi' => $materi_id,
                    'soal_img' => $vRow['soal_img'] !== '' ? $vRow['soal_img'] : null,
                    'pembahasan_img' => $vRow['pembahasan_img'] !== '' ? $vRow['pembahasan_img'] : null,
                    'pembahasan' => $vRow['pembahasan'],
                    'status_cd' => 'normal'
                ];

                $soal_id = $this->soalmodel->simpansoal($soalData);

                if (!$soal_id) {
                    $db->transRollback();
                    return json_encode(['status' => 'error', 'message' => 'Gagal menyimpan soal nomor ' . $vRow['no_soal']]);
                }

                foreach ($vRow['options'] as $pilihan => $optData) {
                    $jawaban_nm = $optData['text'];
                    $jawaban_img = $optData['img'];

                    if ($pilihan === 'E' && $jawaban_nm === '' && $jawaban_img === '') {
                        continue;
                    }

                    $jawabanData = [
                        'soal_id' => $soal_id,
                        'jawaban_nm' => $jawaban_nm,
                        'pilihan_nm' => $pilihan,
                        'jawaban_img' => $jawaban_img !== '' ? $jawaban_img : null,
                        'status_cd' => 'normal'
                    ];

                    $this->jawabanmodel->simpanjawaban($jawabanData);
                }

                $successCount++;
            }

            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                return json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan transaksi saat menyimpan data ke database.']);
            }

            $db->transCommit();
            return json_encode([
                'status' => 'success',
                'message' => 'Berhasil mengimpor ' . $successCount . ' soal beserta kunci dan pembahasan.'
            ]);

        } catch (\Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

}