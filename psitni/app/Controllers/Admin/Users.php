<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Usersmodel;
use App\Models\Soalmodel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Users extends BaseController
{
    protected $session;
    protected $usersmodel;
    protected $soalmodel;
    public function __construct()
	{
		$this->session = \Config\Services::session();
        $this->usersmodel = new Usersmodel();
        $this->soalmodel = new Soalmodel();
        
	}


    public function index() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		} else {
            $data = [
                'users' => $this->usersmodel->getbynormal()->getResult()
            ];
            return view('admin/users',$data);
        } 
    }

    public function resetmateri() {
        $request = \Config\Services::request();
        $user_id = $request->uri->getSegment(4);
        $data = [
            'materi' => $this->soalmodel->getjawAllJMateri()->getResult(),
            'user_id' => $user_id,

            // 'ps' => $this->soalmodel->get()->getResult(),
        ];
        return view('admin/resetmateri',$data);
    }

    public function resetrespon() {
        $request = \Config\Services::request();
        $materi_id = $this->request->getPost("materi_id");
        $group_id = $this->request->getPost("group_id");
        $user_id = $this->request->getPost("user_id");
        $data = [
                "status_cd" => "nullified"
            ];
            $reset = $this->soalmodel->resetsemua($materi_id, $data, $user_id);
        echo json_encode($reset);
    }

    public function tambahuser() {
        return view('admin/users_tambah');
    }

    public function simpanuser() {
        $person_nm = $this->request->getPost("person_nm");
        $satuan = $this->request->getPost("satuan");
        $birth_place = $this->request->getPost("birth_place");
        $birth_dttm = $this->request->getPost("birth_dttm");
        $cellphone = $this->request->getPost("cellphone");
        $addr_txt = $this->request->getPost("addr_txt");
        $user_nm = $this->request->getPost("user_nm");
        $gender_cd = $this->request->getPost("gender_cd");
        $user_group = $this->request->getPost("user_group");
        $email = $this->request->getPost("email");
        $data = [
            "person_nm" => $person_nm,
            "satuan" => $satuan,
            "birth_place" => $birth_place,
            "birth_dttm" => $birth_dttm,
            "cellphone" => $cellphone,
            "addr_txt" => $addr_txt,
            "gender_cd" => $gender_cd,
            "email" => $email,
            'status_cd' => 'normal'
        ];
        $person_id = $this->usersmodel->simpanperson($data);
        $pwd = md5($cellphone);
        $data = [
            "user_nm" => $user_nm,
            "pwd0" => $pwd,
            "user_group" => $user_group,
            "person_id" => $person_id,
            'status_cd' => 'normal'
        ];
        $user_id = $this->usersmodel->simpanuser($data);
        echo json_encode(array("person_id"=>$person_id,"user_id"=>$user_id));
    }

    public function edituser() {
        $person_id = $this->request->getPost("person_id");
        $res = $this->usersmodel->getbyId($person_id)->getResult();
        $dates = '';
        if (!empty($res)) {
            $birth_dttm = $res[0]->birth_dttm ?? '';
            $dates = (!empty($birth_dttm) && $birth_dttm !== '0000-00-00 00:00:00') ? date("Y-m-d", strtotime($birth_dttm)) : '';
        }
        $data = ['res' => $res, 'dates' => $dates, 'person_id' => $person_id];
        return view('admin/users_edit', $data);
    }

    public function updateuser() {
        $person_id = $this->request->getPost("person_id");
        $person_nm = $this->request->getPost("person_nm");
        $satuan = $this->request->getPost("satuan");
        $birth_place = $this->request->getPost("birth_place");
        $birth_dttm = $this->request->getPost("birth_dttm");
        $cellphone = $this->request->getPost("cellphone");
        $addr_txt = $this->request->getPost("addr_txt");
        $user_nm = $this->request->getPost("user_nm");
        $gender_cd = $this->request->getPost("gender_cd");
        $user_group = $this->request->getPost("user_group");
        $email = $this->request->getPost("email");
        $data = [
            "person_nm" => $person_nm,
            "satuan" => $satuan,
            "birth_place" => $birth_place,
            "birth_dttm" => $birth_dttm,
            "cellphone" => $cellphone,
            "addr_txt" => $addr_txt,
            "gender_cd" => $gender_cd,
            "email" => $email,
            'status_cd' => 'normal'
        ];
        $person_id = $this->usersmodel->updateperson($person_id,$data);
        $pwd = md5($cellphone);
        $data = [
            "user_nm" => $user_nm,
            "pwd0" => $pwd,
            "user_group" => $user_group,
            "person_id" => $person_id,
            'status_cd' => 'normal'
        ];
        $user_id = $this->usersmodel->updateuser($person_id,$data);
        echo json_encode(array("person_id"=>$person_id,"user_id"=>$user_id));
    }

    public function hapususer() {
        $person_id = $this->request->getPost('person_id');
        $data = [
            'status_cd' => 'nullified'
        ];
        $this->usersmodel->hapususer($person_id,$data);
        // echo json_encode(array("soal_id"=>$soal_id,"group_nm"=>$group[0]->group_nm));
        echo json_encode("sukses");
    }

    public function hasilexcel() {
        if ($this->session->get("user_nm") == "") {
			return redirect('/');
		}
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
        $res = $this->soalmodel->getPasshandSkor($user_id,"",$materi)->getResult();
        $reskep = $this->soalmodel->getKepribadianSkor($user_id,"",$materi)->getResult();
        $fileName = $user_id."_laporan_".$materi.".xlsx"; 
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
        $columnPasshand = "A";
        $columnkecerdasan = "7";
        $columnkepribadian = "A";
        $sheet->setCellValue("A" . "1", "PASSHAND");
        foreach ($res as $val) {
			$sheet->setCellValue($columnPasshand . "2", $val->no_soal_respon);
            $sheet->setCellValue($columnPasshand . "3", $val->pilihan_respon);
			$columnPasshand++;
		}

        $resSoalKec = $this->soalmodel->resSoalKec(2,$materi)->getResult();

        $sheet->setCellValue("A" . "5", "KECERDASAN");
        $sheet->setCellValue("A" . "6", "SOAL");
        $sheet->setCellValue("B" . "6", "JAWABAN");
        $sheet->setCellValue("G" . "6", "KUNCI");
        $sheet->setCellValue("H" . "6", "HASIL");
        foreach ($resSoalKec as $sl) {
			$sheet->setCellValue("A" . $columnkecerdasan, $sl->no_soal.". ". $sl->soal_nm);
            $resjawaban = $this->soalmodel->getJawabanBysoalId($sl->soal_id)->getResult();
            $clm = "B";
            foreach ($resjawaban as $jwb) {
                $getResponexcel = $this->soalmodel->getResponexcel($sl->soal_id,$jwb->jawaban_id,$user_id,$materi)->getResult();
                if (count($getResponexcel)>0) {
                    if ($getResponexcel[0]->pilihan_nm == $jwb->pilihan_nm) {
                        $sheet->setCellValue($clm . $columnkecerdasan, $jwb->pilihan_nm.". ". $jwb->jawaban_nm);
                        $sheet->getStyle($clm . $columnkecerdasan)->getFont()->setBold(true);
                    } else {
                        $sheet->setCellValue($clm . $columnkecerdasan, $jwb->pilihan_nm.". ". $jwb->jawaban_nm);
                    }

                    if ($getResponexcel[0]->pilihan_nm == $sl->kunci) {
                        $hasilx = "BENAR";
                    } else {
                        $hasilx = "SALAH";
                    }
                    
                } else {
                    $sheet->setCellValue($clm . $columnkecerdasan, $jwb->pilihan_nm.". ". $jwb->jawaban_nm);
                }
                $clm++;
            }

			
			$sheet->setCellValue("G" . $columnkecerdasan, $sl->kunci);
			$sheet->setCellValue("H" . $columnkecerdasan, $hasilx);
			$columnkecerdasan++;
		}

        $columnkecerdasan = $columnkecerdasan + 2;
        $columnkecerdasanx = $columnkecerdasan + 1;
        $resSoalKecx = $this->soalmodel->resSoalKec(3,$materi)->getResult();

        $sheet->setCellValue("A" . $columnkecerdasan, "KEPRIBADIAN");
        $sheet->setCellValue("A" . $columnkecerdasanx, "SOAL");
        $sheet->setCellValue("B" . $columnkecerdasanx, "JAWABAN");
        $sheet->setCellValue("G" . $columnkecerdasanx, "KUNCI");
        $sheet->setCellValue("H" . $columnkecerdasanx, "HASIL");
        foreach ($resSoalKecx as $slx) {
			$sheet->setCellValue("A" . $columnkecerdasanx, $slx->no_soal.". ". $slx->soal_nm);
            $resjawabanx = $this->soalmodel->getJawabanBysoalId($slx->soal_id)->getResult();
            $clm = "B";
            foreach ($resjawabanx as $jwbx) {
                $getResponexcelx = $this->soalmodel->getResponexcelx($slx->soal_id,$jwbx->jawaban_id,$user_id,$materi)->getResult();
                if (count($getResponexcelx)>0) {
                    if ($getResponexcelx[0]->pilihan_nm == $jwbx->pilihan_nm) {
                        $sheet->setCellValue($clm . $columnkecerdasanx, $jwbx->pilihan_nm.". ". $jwbx->jawaban_nm);
                        $sheet->getStyle($clm . $columnkecerdasanx)->getFont()->setBold(true);
                    } else {
                        $sheet->setCellValue($clm . $columnkecerdasanx, $jwbx->pilihan_nm.". ". $jwbx->jawaban_nm);
                    }

                    if ($getResponexcelx[0]->pilihan_nm == $slx->kunci) {
                        $hasilxx = "BENAR";
                    } else {
                        $hasilxx = "SALAH";
                    }
                    
                } else {
                    $sheet->setCellValue($clm . $columnkecerdasanx, $jwbx->pilihan_nm.". ". $jwbx->jawaban_nm);
                }
                $clm++;
            }

			
			$sheet->setCellValue("G" . $columnkecerdasanx, $slx->kunci);
			$sheet->setCellValue("H" . $columnkecerdasanx, $hasilxx);
			$columnkecerdasanx++;
		}

        
		$writer = new Xlsx($spreadsheet);
		$filepath = $fileName;
		$writer->save($filepath);
 
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filepath));
		flush();
		readfile($filepath);
		exit;
    }

    public function hasilpdf() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
            $benar_passhand = 0;
            $salah_passhand = 0;
            $benar_kec = 0;
            $salah_kec = 0;
            $benar_keb = 0;
            $salah_keb = 0;
            $benar_sk  = 0;
            $salah_sk  = 0;
            $total_skor  = 0;
            $persen_kec  = 0;
            $persen_kep  = 0;
            $persen_sk = 0;
            $ttl_benar_sk = 0;
            $passhandjwb = "";

            $resuser = $this->usersmodel->getbyUserId($user_id)->getResult();

            $passhandskor = $this->soalmodel->getPasshandSkor($user_id,"",$materi)->getResult();
            if (count($passhandskor)>0) {
                $passhandjwb .= "<div>
                        <ul style=\"margin-top: 10px;margin-bottom: 18px;font-size: 10px;display: grid;grid-template-columns: auto 1fr;grid-gap: 0 2em;max-width : 100%;z-index: 20;color: rgb(109, 113, 107);box-shadow: rgb(162, 151, 151) 3px 3px 10px;cursor: pointer !important;list-style: none;background: rgb(255, 255, 255);padding: 10px 12px;\">";
                foreach ($passhandskor as $key) {
                    $passhandjwb .= "<li style=\"display: inline-block;width: 100%;padding: 2px;\">".$key->no_soal.". <label style=\"margin-left:15px;\">".$key->pilihan_respon.".</label> ".$key->jawaban_nm."</li>";
                }
                $passhandjwb .= "</ul>
                        </div>";
            } 

            

            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($user_id,"",$materi)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }
            }
            $persen_kec = ($benar_kec * 0.0025) * 100;
            // log_message("info",$persen_kec);
            $kepskor = $this->soalmodel->getKepribadianSkor($user_id,"",$materi)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }
            $persen_kep = ($benar_keb * 0.005) * 100;

            $skskor = "<div style=\"width:100%;text-align:center;\">
                                <table border=\"1\" style=\"line-height:1.5;\"><thead><tr>
                                <th align=\"center\">Kolom</th>
                                <th align=\"center\">Soal Terjawab</th>
                                <th align=\"center\">Benar</th>
                                <th align=\"center\">Salah</th>
                                </tr></thead>
                                <tbody>";
                                
                                $kolom_nm = [];
                                $soal_terjawab_chart = [];
                                $jawaban_benar_chart = [];
                                $klm = $this->soalmodel->getKolomSoal()->getResult();
                                foreach ($klm as $key) {
                                    $kolom_nm[] = $key->kolom_nm;
                                    $benar = 0;
                                    $salah = 0;
                                    $soal_terjawab = 0;
                                    $res_responSK = $this->soalmodel->getResponSikapKerja($user_id,"",$key->kolom_id,$materi)->getResult();
                                    if (count($res_responSK)>0) {
                                        $soal_terjawab = count($res_responSK);
                                        foreach ($res_responSK as $rSK) {
                                            // $soal_terjawab = $soal_terjawab + 1;
                                            if ($rSK->pilihan_respon == $rSK->kunci) {
                                                $benar = $benar + 1;
                                            } else {
                                                $salah = $salah + 1;
                                            }
                                            
                                        }
                                    } else {
                                        $soal_terjawab = $soal_terjawab;
                                    }
                                    $ttl_benar_sk = $ttl_benar_sk + $benar;
                                    $soal_terjawab_chart[] =  $soal_terjawab;
                                    $jawaban_benar_chart[] = $benar;
                                    $skskor .= "<tr><td>".$key->kolom_nm."</td> <td>$soal_terjawab</td> <td>$benar</td> <td>$salah</td></tr>";
                                }
                                $persen_sk = ($ttl_benar_sk * 0.0005) * 100;
                        $skskor .= "</tbody></table>
                            </div>";

            $total_skor = $persen_sk + $persen_kep + $persen_kec;
            if ($total_skor >= 61) {
                $styletotalskor = "color:green;";
                $syarat = "(Memenuhi Syarat - MS)";
            } else {
                $styletotalskor = "color:red;";
                $syarat = "(Tidak Memenuhi Syarat - TMS)";
            }

            $birth_place = esc($resuser[0]->birth_place ?? '');
            $birth_dttm = !empty($resuser[0]->birth_dttm) ? date("d-m-Y", strtotime($resuser[0]->birth_dttm)) : '';
            $ttl = $birth_place . ($birth_dttm ? ", " . $birth_dttm : "");
            $gender = (($resuser[0]->gender_cd ?? '') == 'l') ? 'Laki-laki' : ((($resuser[0]->gender_cd ?? '') == 'm') ? 'Perempuan' : esc($resuser[0]->gender_cd ?? ''));
            $email = esc($resuser[0]->email ?? '');
            $cellphone = esc($resuser[0]->cellphone ?? '');
            $user_nm = esc($resuser[0]->user_nm ?? '');
            $satuan = esc($resuser[0]->satuan ?? '');

            $ret = "
            <div style=\"color:#000000; font-family: helvetica;\">
                <div style=\"text-align:center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 15px;\">
                    <h2 style=\"margin: 0; font-size: 16px;\">LAPORAN HASIL TRYOUT</h2>
                    <h3 style=\"margin: 5px 0 0 0; font-size: 12px; color: #555;\">Materi: " . esc($materi) . "</h3>
                </div>
                
                <table cellpadding=\"4\" style=\"margin-bottom: 15px; font-size: 10px; width: 100%;\">
                    <tr>
                        <td width=\"120\"><b>Nama Peserta</b></td>
                        <td width=\"15\">:</td>
                        <td width=\"365\">" . esc($resuser[0]->person_nm ?? '') . "</td>
                    </tr>
                    <tr>
                        <td><b>TTL</b></td>
                        <td>:</td>
                        <td>" . $ttl . "</td>
                    </tr>
                    <tr>
                        <td><b>Jenis Kelamin</b></td>
                        <td>:</td>
                        <td>" . $gender . "</td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>:</td>
                        <td>" . $email . "</td>
                    </tr>
                    <tr>
                        <td><b>No. HP</b></td>
                        <td>:</td>
                        <td>" . $cellphone . "</td>
                    </tr>
                    <tr>
                        <td><b>Username</b></td>
                        <td>:</td>
                        <td>" . $user_nm . "</td>
                    </tr>
                    <tr>
                        <td><b>Satuan</b></td>
                        <td>:</td>
                        <td>" . $satuan . "</td>
                    </tr>
                </table>
                
                <hr style=\"border: none; border-top: 1px solid #ddd; margin-top: 10px; margin-bottom: 10px;\">
                
                <table cellpadding=\"4\" style=\"font-size: 11px; margin-bottom: 15px; width: 100%;\">
                    <tr>
                        <td width=\"120\"><b>TOTAL SKOR</b></td>
                        <td width=\"15\">:</td>
                        <td width=\"365\"><b style=\"" . $styletotalskor . "\">" . $total_skor . " " . $syarat . "</b></td>
                    </tr>
                </table>
            </div>";
            $ret .= "<div>
                        <div>
                        <table border=\"1\" style=\"table-layout:fixed;color:#000000;\">
                        <tbody>
                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td width=\"150\">Passhand</td>
                            <td width=\"20\" colspan=\"2\" style=\"text-align:center;\">:</td></tr>
                            <tr style=\"font-size:10px;border-bottom:1px solid black;\"><td colspan=\"3\">$passhandjwb</td></tr>

                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td>Kecerdasan</td>
                            <td width=\"20\" style=\"text-align:center;\">:</td>
                            <td width=\"50\" style=\"text-align:center;\"><label>$persen_kec</label></td></tr>

                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td>Kepribadian</td>
                            <td style=\"text-align:center;\">:</td>
                            <td style=\"text-align:center;\"><label>$persen_kep</label></td></tr>

                            <tr style=\"font-size:15px;border-bottom:1px solid black;\">
                            <td>Sikap Kerja</td>
                            <td style=\"text-align:center;\">:</td>
                            <td style=\"text-align:center;\"><label>$persen_sk</label></td></tr>
                        </tbody>
                        </table>
                        </div>";
            $ret .= $skskor;
            // $ret .= "";
           $ret .= "<div class=\"card-body\">
                    <div class=\"chart\">
                        <canvas id=\"barChart\" style=\"min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;\"></canvas> 
                    </div>
                    </div>";
            $ret .= "</div>";
            $js = "<script src=\"../../../../plugins/jquery/jquery.min.js\"></script><script src=\"../../../../plugins/chart.js/Chart.min.js\"></script>";
            $js .= "var barChartCanvas = $(\"#barChart\").get(0).getContext(\"2d\");
            var areaChartData = {
            labels  : ".json_encode($kolom_nm).",
            datasets: [
                {
                  label               : \"Jawaban Benar\",
                  backgroundColor     : \"rgba(60,141,188,0.9)\",
                  borderColor         : \"rgba(60,141,188,0.8)\",
                  pointRadius          : false,
                  pointColor          : \"#3b8bba\",
                  pointStrokeColor    : \"rgba(60,141,188,1)\",
                  pointHighlightFill  : \"#fff\",
                  pointHighlightStroke: \"rgba(60,141,188,1)\",
                  data                : ".json_encode($jawaban_benar_chart).",
                  bezierCurve : false
                },
                {
                  label               : \"Soal Terjawab\",
                  backgroundColor     : \"rgba(210, 214, 222, 1)\",
                  borderColor         : \"rgba(210, 214, 222, 1)\",
                  pointRadius         : false,
                  pointColor          : \"rgba(210, 214, 222, 1)\",
                  pointStrokeColor    : \"#c1c7d1\",
                  pointHighlightFill  : \"#fff\",
                  pointHighlightStroke: \"rgba(220,220,220,1)\",
                  data                : ".json_encode($soal_terjawab_chart)."
                },
              ]
          }
          
            
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
              responsive              : true,
              maintainAspectRatio     : false,
              datasetFill             : false,
            }

            new Chart(barChartCanvas, {
              type: \"bar\",
              data: barChartData,
              options: barChartOptions
            })";

        

        $html = view('admin/hasilpdf',[
			'ret'=> $ret
		]);

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Bintang Timur Prestasi');
		$pdf->SetTitle('Hasil Tes');
		$pdf->SetSubject('Hasil Tes');
        $pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
        $pdf->addPage();

        // output the HTML content
        // $pdf->IncludeJS($js);
		$pdf->writeHTML($html, true, false, true, false, '');
        $pdf->IncludeJS($js);
		//line ini penting
		$this->response->setContentType('application/pdf');
		//Close and output PDF document
		$pdf->Output('invoice.pdf', 'I');
    }

    public function hasilweb() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
            $benar_passhand = 0;
            $salah_passhand = 0;
            $benar_kec = 0;
            $salah_kec = 0;
            $benar_keb = 0;
            $salah_keb = 0;
            $benar_sk  = 0;
            $salah_sk  = 0;
            $total_skor  = 0;
            $persen_kec  = 0;
            $persen_kep  = 0;
            $persen_sk = 0;
            $ttl_benar_sk = 0;
            $passhandjwb = "";
            $date_tes = "";
            $resuser = $this->usersmodel->getbyUserId($user_id)->getResult();

            $passhandskor = $this->soalmodel->getPasshandSkor($user_id,"",$materi)->getResult();
            foreach ($passhandskor as $key) {
                $passhandjwb .= "<li style=\"display: inline-block;width: 100%;padding: 2px;\">".$key->no_soal.". <label style=\"margin-left:15px;\">".$key->pilihan_respon.".</label> ".$key->jawaban_nm."</li>";

                
            }

            $kecerdasanskor = $this->soalmodel->getKecerdasanSkor($user_id,"",$materi)->getResult();
            foreach ($kecerdasanskor as $kec) {
                if ($kec->kunci == $kec->pilihan_nm) {
                    $benar_kec = $benar_kec + 1;
                } else {
                    $salah_kec = $salah_kec + 1;
                }

                $date_tes = $kec->created_dttm;
            }
            $persen_kec = ($benar_kec * 0.0025) * 100;
            // log_message("info",$persen_kec);
            $kepskor = $this->soalmodel->getKepribadianSkor($user_id,"",$materi)->getResult();
            foreach ($kepskor as $kep) {
                if ($kep->kunci == $kep->pilihan_nm) {
                    $benar_keb = $benar_keb + 1;
                } else {
                    $salah_keb = $salah_keb + 1;
                }
            }
            $persen_kep = ($benar_keb * 0.005) * 100;

            $skskor = "<div style=\"width:100%;text-align:center;\">
                                <ul style=\"list-style-type: none;font-size:15px;\">";
                                
                                $kolom_nm = [];
                                $soal_terjawab_chart = [];
                                $jawaban_benar_chart = [];
                                $klm = $this->soalmodel->getKolomSoal()->getResult();
                                foreach ($klm as $key) {
                                    $kolom_nm[] = $key->kolom_nm;
                                    $benar = 0;
                                    $salah = 0;
                                    $soal_terjawab = 0;
                                    $res_responSK = $this->soalmodel->getResponSikapKerja($user_id,"",$key->kolom_id,$materi)->getResult();
                                    if (count($res_responSK)>0) {
                                        $soal_terjawab = count($res_responSK);
                                        foreach ($res_responSK as $rSK) {
                                            // $soal_terjawab = $soal_terjawab + 1;
                                            if ($rSK->pilihan_respon == $rSK->kunci) {
                                                $benar = $benar + 1;
                                            } else {
                                                $salah = $salah + 1;
                                            }
                                            
                                        }
                                    } else {
                                        $soal_terjawab = $soal_terjawab;
                                    }
                                    $ttl_benar_sk = $ttl_benar_sk + $benar;
                                    $soal_terjawab_chart[] =  $soal_terjawab;
                                    $jawaban_benar_chart[] = $benar;
                                    $skskor .= "<li>".$key->kolom_nm." : <label>[$soal_terjawab soal terjawab]</label> - <label>$benar</label> benar | <label>$salah</label> salah</li>";
                                }
                                $persen_sk = ($ttl_benar_sk * 0.0005) * 100;
                        $skskor .= "</ul>
                            </div>";

            $total_skor = $persen_sk + $persen_kep + $persen_kec;
            if ($materi == 4) {
                $ressession = $this->soalmodel->getSessionSkor($this->session->user_id)->getResult();
                foreach ($ressession as $sesskr) {
                    $persen_kec  = $sesskr->skor_kec; 
                    $persen_kep  = $sesskr->skor_kep;
                    $persen_sk   = $sesskr->skor_sk;
                    $total_skor = $persen_sk + $persen_kep + $persen_kec;
                }
            }
            
            if ($total_skor >= 61) {
                $styletotalskor = "color:green;";
                $syarat = "(Memenuhi Syarat - MS)";
            } else {
                $styletotalskor = "color:red;";
                $syarat = "(Tidak Memenuhi Syarat - TMS)";
            }

            $ret = "<div>
                        <div style=\"width:100%;height: 100%;text-align:center;color:#000000;\">
                            <h1>Materi ".$materi."</h1>
                        </div>
                        <div>
                        <table style=\"table-layout:fixed;color:#000000;width:100%;\">
                        <tbody>
                        <tr style=\"font-size:20px;border-bottom:1px solid black;\"><td width=\"150\">Passhand</td><td width=\"20\" style=\"text-align:center;\">:</td><td></td></tr>

                        <tr style=\"font-size:20px;border-bottom:1px solid black;height: 50px;\"><td>Kecerdasan</td><td width=\"20\" style=\"text-align:center;\">:</td><td width=\"50\" style=\"text-align:center;\"><label>$persen_kec</label></td></tr>
                        <tr style=\"font-size:20px;border-bottom:1px solid black;height: 50px;\"><td>Kepribadian</td><td style=\"text-align:center;\">:</td><td style=\"text-align:center;\"><label>$persen_kep</label></td></tr>
                        <tr style=\"font-size:20px;border-bottom:1px solid black;height: 50px;\"><td>Sikap Kerja</td><td style=\"text-align:center;\">:</td><td style=\"text-align:center;\"><label>$persen_sk</label></td></tr>
                        </tbody>
                        </table>
                        </div>";
            $ret .= $skskor;
            $date_tes = date('d F Y', strtotime($date_tes));
            $ret .= "<div class=\"card-body\">
                    <div class=\"chart\">
                        <canvas id=\"barChart\" style=\"min-height: 350px; height: 350px; max-height: 350px; max-width: 80%;\"></canvas> 
                        <img id=\"urls\" />  
                    </div>
                    </div>";
            $ret .= "<div class=\"col-md-12 row\">"
                 . "<div style=\"margin-left:50px;text-align:center;\" class=\"col-md-4\"><p> Hasil CAT : <span style=\"$styletotalskor\">$syarat</span> </p> <span style=\"font-size:100px;\">".$total_skor."</span><p><h4>".$resuser[0]->person_nm."</h4></p></div>"
                 . "<div style=\"margin-left:50px;text-align:right;\" class=\"col-md-6\"><p>Palembang, ".$date_tes."</p><p><img style=\"max-width:100%;height: 150px;margin-right: 30px;\" src=\"".base_url()."/images/frame.png\" /></p><p><h4 style=\"margin-right:55px;\">PENGUJI</h4></p></div>"
                 . "</div>";
            $ret .= "</div>";
          

            $data = [
                'ret' => $ret,
                'kolom_nm' => $kolom_nm,
                'jawaban_benar_chart' => $jawaban_benar_chart,
                'soal_terjawab_chart' => $soal_terjawab_chart
            ];
            return view('admin/hasilweb',$data);

    }

    public function hasillatihan() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
        $benar_sk  = 0;
        $salah_sk  = 0;
        $persen_sk = 0;
        $ttl_benar_sk = 0;

            $resuser = $this->usersmodel->getbyUserId($user_id)->getResult();
            $responlatihan = $this->soalmodel->getResponLatihan($user_id)->getResult();
            $skused = "";
            if (count($responlatihan)>0) {
                foreach ($responlatihan as $lat) {
                    $used = $lat->used;
                    $skused .= "<div style='display:inline-block;border:1px solid black;margin:10px;width: 90px;text-align: center;border-radius:10px;background-color: deepskyblue;cursor:pointer;.'><a target='_blank' href='".base_url()."/admin/users/hasilused/$user_id/$materi/$used' id='dv_used_{$used}' style='width: 100%;height:100%;cursor:pointer;color:#000000;'><label for='dv_used_{$used}' style='font-size:50px;cursor:pointer;'>".$lat->used."</label><label style='cursor:pointer;' for='dv_used_{$used}' style='font-size:14px;'>".$lat->used_dttm."</label></a></div>";
                }
            } else {
                $skused = "";
            }
            
            $ret = "<div>
                        <div style=\"width:100%;height: 100%;text-align:center;color:#000000;\">
                            <h1>".$resuser[0]->person_nm."</h1>
                        </div>
                        <div>

                        </div>";
            $ret .= $skused;
            // $date_tes = date('d F Y', strtotime($date_tes));
            
            $ret .= "</div>";
          

            $data = [
                'ret' => $ret
            ];
            return view('admin/hasillatihan',$data);
    }

    public function hasilused() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);
        $used = $this->request->getUri()->getSegment(6);

        $ret = "<div class='col-lg-12' style='color:#000000;'>
                        <a href='".base_url()."'><button class='btn btn-primary'>Menu Utama</button></a>
                            <div style='width:100%;text-align:center;'>
                                <p style='margin:10px;font-size:18px;'>Nilai yang tampil merupakan hasil dari jumlah soal yang terjawab, dan bukan merupakan bobot penilaian seperti saat tes sesungguhnya.</p>
                                <div style='background-color: #007bff;border-radius:10px;'><h2 style='margin:10px;color:white;'>HASIL PENILAIAN</h2></div>
                            </div>
                            <div style='width:100%;text-align:center;'>
                                <ul style='list-style-type: none;'>";
                                $kolom_nm = [];
                                $soal_terjawab_chart = [];
                                $jawaban_benar_chart = [];
                                $klm = $this->soalmodel->getKolomSoal()->getResult();
                                foreach ($klm as $key) {
                                $kolom_nm[] = $key->kolom_nm;
                                $benar = 0;
                                $salah = 0;
                                $soal_terjawab = 0;
                                    $res_responSK = $this->soalmodel->getResponSKLatihan($user_id,$used,$key->kolom_id,$materi)->getResult();
                                    if (count($res_responSK)>0) {
                                        $soal_terjawab = count($res_responSK);
                                        foreach ($res_responSK as $rSK) {
                                            // $soal_terjawab = $soal_terjawab + 1;
                                            if ($rSK->pilihan_respon == $rSK->kunci) {
                                                $benar = $benar + 1;
                                            } else {
                                                $salah = $salah + 1;
                                            }
                                            
                                        }
                                    } else {
                                        $soal_terjawab = $soal_terjawab;
                                    }
                                    $soal_terjawab_chart[] =  $soal_terjawab;
                                    $jawaban_benar_chart[] = $benar;
                                    $ret .= "<li>".$key->kolom_nm." : <label>[$soal_terjawab soal terjawab]</label> - <label>$benar</label> benar | <label>$salah</label> salah</li>";
                                }
                                "</ul>
                            </div>";
                $ret .= "<div class='card'>
                            <div class='card-body'>
                            <div class='chart'>
                                <canvas id='barChart' style='min-height: 350px; height: 350px; max-height: 350px; max-width: 100%;'></canvas>
                            </div>
                            </div>
                        </div>";
                $ret .= "</div>";

                $data = [
                    'ret' => $ret,
                    'kolom_nm' => $kolom_nm,
                    'jawaban_benar_chart' => $jawaban_benar_chart,
                    'soal_terjawab_chart' => $soal_terjawab_chart
                ];
                return view('admin/hasilweb',$data);
    }


    public function hasilpdf_salah() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);

        $mhs = $this->usersmodel->getbyUserId($user_id)->getResult();
        if (empty($mhs)) {
            echo "Data user tidak ditemukan";
            exit;
        }

        $getResponHasilSalah = $this->soalmodel->getResponHasilSalah("", $materi, $user_id)->getResult();

        $pdf2 = new \TCPDF();
        $pdf2->AddPage();
        $pdf2->setPrintHeader(false);
        $pdf2->setPrintFooter(false);

        $soalsalah = "";
        $currentGroup = "";

        if (count($getResponHasilSalah) > 0) {
            foreach ($getResponHasilSalah as $key) {
                $soal_nm = $key->soal_nm == '' ? '-' : $key->soal_nm ?? '-';
                $pilihan_nm = $key->pilihan_nm ?? '-';
                $jawaban_nm = $key->jawaban_nm ?? '-';
                $kunci = $key->kunci ?? '-';
                $kunci_jawaban_nm = $key->kunci_jawaban_nm ?? '-';
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
                    $path = $basePath . 'images/pembahasan/' . $key->materi . '/group/' . $key->group_soal_id . '/' . $key->pembahasan_img;
                    if (file_exists($path)) {
                        $pembahasan_img = '<img src="'.$path.'" width="150" height="100">';
                    }
                }

                // Gambar soal
                $img_soal = "";
                if (!empty($key->soal_img)) {
                    $path = $basePath . 'images/soal/materi/' . $key->materi . '/group/' . $key->group_soal_id . '/' . $key->soal_img;
                    if (file_exists($path)) {
                        $img_soal = '<img src="'.$path.'" width="150" height="100">';
                    }
                }
                // Gambar jawaban user
                $img_jawaban = "";
                if (!empty($key->jawaban_img)) {
                    $path = $basePath . 'images/jawaban/materi/' . $key->materi . '/group/' . $key->group_soal_id . '/' . $key->jawaban_img;
                    if (!file_exists($path) && strpos($key->jawaban_img, '.') === false) {
                        $path .= '.jpg';
                    }
                    if (file_exists($path)) {
                        $img_jawaban = '<img src="'.$path.'" width="150" height="100">';
                    }
                }

                // Gambar kunci jawaban
                $img_kunci = "";
                if (!empty($key->kunci_jawaban_img)) {
                    $path = $basePath . 'images/jawaban/materi/' . $key->materi . '/group/' . $key->group_soal_id . '/' . $key->kunci_jawaban_img;
                    if (!file_exists($path) && strpos($key->kunci_jawaban_img, '.') === false) {
                        $path .= '.jpg';
                    }
                    if (file_exists($path)) {
                        $img_kunci = '<img src="'.$path.'" width="150" height="100">';
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
                                <td width="77%">'.strip_tags($soal_nm).(!empty($img_soal) ? '<br>'.$img_soal : '').'</td>
                            </tr>
                            <tr>
                                <td>Jawaban</td>
                                <td>:</td>
                                <td>'.$pilihan_nm.'. '.strip_tags($jawaban_nm).(!empty($img_jawaban) ? '<br>'.$img_jawaban : '').'</td>
                            </tr>
                            <tr>
                                <td>Kunci</td>
                                <td>:</td>
                                <td>'.$kunci.'. '.strip_tags($kunci_jawaban_nm).(!empty($img_kunci) ? '<br>'.$img_kunci : '').'</td>
                            </tr>
                            <tr>
                                <td>Pembahasan</td>
                                <td>:</td>
                                <td>'.strip_tags($pembahasan).(!empty($pembahasan_img) ? '<br>'.$pembahasan_img : '').'</td>
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

        $filenameSalah = str_replace(" ", "_", $mhs[0]->person_nm)."_materi".$materi."_SALAH.pdf";
        
        $this->response->setContentType('application/pdf');
        $pdf2->Output($filenameSalah, 'I');
        exit;
    }

    public function hasilpdf_pauli() {
        $user_id = $this->request->getUri()->getSegment(4);
        $materi = $this->request->getUri()->getSegment(5);

        $mhs = $this->usersmodel->getbyUserId($user_id)->getResult();
        if (empty($mhs)) {
            echo "Data user tidak ditemukan";
            exit;
        }

        $chart1File = WRITEPATH . 'upload/chartpauli/chart_' . $materi . '_' . $mhs[0]->user_nm . '_1.png';
        $chart2File = WRITEPATH . 'upload/chartpauli/chart_' . $materi . '_' . $mhs[0]->user_nm . '_2.png';
        $chart3File = WRITEPATH . 'upload/chartpauli/chart_' . $materi . '_' . $mhs[0]->user_nm . '_3.png';
        $chart4File = WRITEPATH . 'upload/chartpauli/chart_' . $materi . '_' . $mhs[0]->user_nm . '_4.png';

        $hasil = [];
        for ($i = 1; $i <= 4; $i++) {
            $hasil[$i] = $this->soalmodel
                ->getHasilPauliByUserUsed(
                    $user_id,
                    $i,
                    $materi,
                    1
                )
                ->getResult();
        }

        $pdf3 = new \TCPDF();
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

        if (file_exists($chart1File) || file_exists($chart2File) || file_exists($chart3File) || file_exists($chart4File)) {
            $pdf3->AddPage();
            $htmlChart = '
                <h2 align="center">Grafik Pauli</h2>

                <table border="0" width="100%" cellpadding="5">
                    <tr>
                        <td align="center">
                            <h4>Lembar 1</h4>
                            '.(file_exists($chart1File) ? '<img src="'.$chart1File.'" height="500">' : '<p>Grafik Lembar 1 tidak ditemukan</p>').'
                        </td>
                        <td align="center">
                            <h4>Lembar 2</h4>
                            '.(file_exists($chart2File) ? '<img src="'.$chart2File.'" height="500">' : '<p>Grafik Lembar 2 tidak ditemukan</p>').'
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <h4>Lembar 3</h4>
                            '.(file_exists($chart3File) ? '<img src="'.$chart3File.'" height="500">' : '<p>Grafik Lembar 3 tidak ditemukan</p>').'
                        </td>
                        <td align="center">
                            <h4>Lembar 4</h4>
                            '.(file_exists($chart4File) ? '<img src="'.$chart4File.'" height="500">' : '<p>Grafik Lembar 4 tidak ditemukan</p>').'
                        </td>
                    </tr>
                </table>
                ';
            $pdf3->writeHTML($htmlChart, true, false, true, false, '');
        }

        $filenamePauli = str_replace(" ", "_", $mhs[0]->person_nm)."_materi".$materi."_PAULI.pdf";
        $this->response->setContentType('application/pdf');
        $pdf3->Output($filenamePauli, 'I');
        exit;
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
            $tidak_jawab = $row->tidak_terjawab ?? $row->tidak_jawab ?? 0;
            $html .= '
            <tr>
                <td align="center">'.$no++.'</td>
                <td>'.$row->kolom_nm.'</td>
                <td align="center">'.$row->terjawab.'</td>
                <td align="center">'.$tidak_jawab.'</td>
                <td align="center">'.$row->salah.'</td>
            </tr>
            ';
        }

        $html .= '</table>';

        return $html;
    }
}
