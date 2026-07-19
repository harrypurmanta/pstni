<div class="modal-header bg-primary text-white py-2">
    <h6 class="modal-title"><i class="fas fa-user-plus mr-2"></i> Tambah User Baru</h6>
    <button type="button" class="close text-white py-2" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body py-2">
    <form id="formTambahUser">
        <div class="row">
            <div class="col-6 pr-1">
                <div class="form-group mb-2">
                    <label for="person_nm" class="small mb-1 font-weight-bold">Nama Lengkap</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user text-primary"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="person_nm" name="person_nm" placeholder="Nama lengkap">
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="satuan" class="small mb-1 font-weight-bold">Satuan</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-shield-alt text-primary"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 pr-1">
                <div class="form-group mb-2">
                    <label for="birth_place" class="small mb-1 font-weight-bold">Tempat Lahir</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt text-primary"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="birth_place" name="birth_place" placeholder="Tempat lahir">
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="birth_dttm" class="small mb-1 font-weight-bold">Tanggal Lahir</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt text-primary"></i></span>
                        </div>
                        <input type="date" class="form-control form-control-sm" id="birth_dttm" name="birth_dttm">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 pr-1">
                <div class="form-group mb-2">
                    <label for="gender_cd" class="small mb-1 font-weight-bold">Jenis Kelamin</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-venus-mars text-primary"></i></span>
                        </div>
                        <select class="form-control form-control-sm" id="gender_cd" name="gender_cd">
                            <option value="l">Laki-laki</option>
                            <option value="m">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="cellphone" class="small mb-1 font-weight-bold">No. HP</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone text-primary"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="cellphone" name="cellphone" placeholder="No. HP">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 pr-1">
                <div class="form-group mb-2">
                    <label for="user_nm" class="small mb-1 font-weight-bold">Username</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tag text-primary"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="user_nm" name="user_nm" placeholder="Username">
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="email" class="small mb-1 font-weight-bold">Email</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
                        </div>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 pr-1">
                <div class="form-group mb-2">
                    <label for="user_group" class="small mb-1 font-weight-bold">Level User</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-shield text-primary"></i></span>
                        </div>
                        <select class="form-control form-control-sm" id="user_group" name="user_group">
                            <option value="siswa">Siswa</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="addr_txt" class="small mb-1 font-weight-bold">Alamat</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home text-primary"></i></span>
                        </div>
                        <textarea class="form-control form-control-sm" id="addr_txt" name="addr_txt" rows="1" placeholder="Alamat lengkap"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer bg-light py-2">
    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
    <button onclick="simpanuser()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
</div>
