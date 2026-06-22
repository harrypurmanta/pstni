<div class='card'>
    <div class='card-body'>
        <div class='row'>
            <div class='col-sm-12'>
                <div class='form-group'>
                    <div class='card-body'>
                        <div class='form-group row'>
                            <label for='person_nm' class='col-sm-2 col-form-label'>Nama</label>
                            <div class='col-4'>
                                <input type='text' class='form-control' id='person_nm' name='person_nm'>
                            </div>
                            <label for='satuan' class='col-sm-2 col-form-label'>Satuan</label>
                            <div class='col-4'>
                                <input type='text' class='form-control' id='satuan' name='satuan'>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label for='birth_place' class='col-sm-2 col-form-label'>Tempat Lahir</label>
                            <div class='col-4'>
                                <input type='text' class='form-control' id='birth_place' name='birth_place'>
                            </div>
                            <label for='birth_dttm' class='col-sm-2 col-form-label'>Tanggal Lahir</label>
                            <div class='col-4'>
                                <input type='date' class='form-control' id='birth_dttm' name='birth_dttm'>
                            </div>
                        </div>

                        <div class='form-group row'>
                            <label for='gender_cd' class='col-sm-2 col-form-label'>Jenis Kelamin</label>
                            <div class='col-4'>
                                <select class='form-control' id='gender_cd' name='gender_cd'>
                                    <option value='l'>Laki-laki</option>
                                    <option value='m'>Perempuan</option>
                                </select>
                            </div>
                            <label for='cellphone' class='col-sm-2 col-form-label'>No. HP</label>
                            <div class='col-4'>
                                <input type='text' class='form-control' id='cellphone' name='cellphone'>
                            </div>
                        </div>

                        <div class='form-group row'>
                            <label for='user_nm' class='col-sm-2 col-form-label'>Username</label>
                            <div class='col-4'>
                                <input type='text' class='form-control' id='user_nm' name='user_nm'>
                            </div>
                            <label for='addr_txt' class='col-sm-2 col-form-label'>Alamat</label>
                            <div class='col-4'>
                                <textarea class='form-control' id='addr_txt' name='addr_txt'></textarea>
                            </div>
                        </div>

                        <div class='form-group row'>
                            <label for='user_group' class='col-sm-2 col-form-label'>Level User</label>
                            <div class='col-4'>
                                <select class='form-control' id='user_group' name='user_group'>
                                    <option value='siswa'>Siswa</option>
                                    <option value='admin'>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class='card-footer'>
                        <button onclick='simpanuser()' type='button' class='btn btn-info'>Simpan</button>
                        <button type='button' class='btn btn-default float-right' data-dismiss='modal' aria-label='Close'>Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
