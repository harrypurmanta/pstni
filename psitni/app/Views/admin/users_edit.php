<div class="modal-header bg-success text-white py-2">
    <h6 class="modal-title"><i class="fas fa-user-edit mr-2"></i> Edit Data User</h6>
    <button type="button" class="close text-white py-2" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body py-2">
    <form id="formEditUser">
        <div class="row">
            <div class="col-6 pr-1">
                <div class="form-group mb-2">
                    <label for="person_nm" class="small mb-1 font-weight-bold">Nama Lengkap</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user text-success"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="person_nm" name="person_nm" value="<?= esc($res[0]->person_nm ?? '') ?>" placeholder="Nama lengkap">
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="satuan" class="small mb-1 font-weight-bold">Satuan</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-shield-alt text-success"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="satuan" name="satuan" value="<?= esc($res[0]->satuan ?? '') ?>" placeholder="Satuan">
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
                            <span class="input-group-text"><i class="fas fa-map-marker-alt text-success"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="birth_place" name="birth_place" value="<?= esc($res[0]->birth_place ?? '') ?>" placeholder="Tempat lahir">
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="birth_dttm" class="small mb-1 font-weight-bold">Tanggal Lahir</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt text-success"></i></span>
                        </div>
                        <input type="date" class="form-control form-control-sm" id="birth_dttm" name="birth_dttm" value="<?= esc($dates ?? '') ?>">
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
                            <span class="input-group-text"><i class="fas fa-venus-mars text-success"></i></span>
                        </div>
                        <select class="form-control form-control-sm" id="gender_cd" name="gender_cd">
                            <option value="l" <?= (($res[0]->gender_cd ?? '') == 'l') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="m" <?= (($res[0]->gender_cd ?? '') == 'm') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="cellphone" class="small mb-1 font-weight-bold">No. HP</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone text-success"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="cellphone" name="cellphone" value="<?= esc($res[0]->cellphone ?? '') ?>" placeholder="No. HP">
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
                            <span class="input-group-text"><i class="fas fa-user-tag text-success"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="user_nm" name="user_nm" value="<?= esc($res[0]->user_nm ?? '') ?>" placeholder="Username">
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="email" class="small mb-1 font-weight-bold">Email</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope text-success"></i></span>
                        </div>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?= esc($res[0]->email ?? '') ?>" placeholder="Email">
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
                            <span class="input-group-text"><i class="fas fa-user-shield text-success"></i></span>
                        </div>
                        <select class="form-control form-control-sm" id="user_group" name="user_group">
                            <option value="siswa" <?= (($res[0]->user_group ?? '') == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                            <option value="admin" <?= (($res[0]->user_group ?? '') == 'admin') ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6 pl-1">
                <div class="form-group mb-2">
                    <label for="addr_txt" class="small mb-1 font-weight-bold">Alamat</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-home text-success"></i></span>
                        </div>
                        <textarea class="form-control form-control-sm" id="addr_txt" name="addr_txt" rows="1" placeholder="Alamat lengkap"><?= esc($res[0]->addr_txt ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer bg-light py-2">
    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Batal</button>
    <button onclick="updateuser(<?= $person_id ?>)" type="button" class="btn btn-sm btn-success"><i class="fas fa-check mr-1"></i> Simpan Perubahan</button>
</div>
