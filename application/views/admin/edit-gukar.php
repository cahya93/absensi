<div class="row">
    <div class="col-lg-8">
        <div class="card-body pb-0">
            <?= $this->session->flashdata('message'); ?>
            <form action="" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NBM</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" id="nbm" name="nbm" value="<?= $data['nbm']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" id="nama" name="nama" value="<?= $data['nama']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" id="email" name="email" value="<?= $data['email']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jabatan</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" id="jabatan" name="jabatan"
                            value="<?= $data['jabatan']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No. HP</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="text" id="hp" name="hp" value="<?= $data['hp']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status Pegawai</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="id_keterangan" id="id_keterangan">
                            <option value="">--Pilih Status--</option>
                            <?php foreach($keterangan as $k): ?>
                            <option value="<?= $k['id']; ?>"><?= $k['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                <input type="hidden" name="user" id="user" value="<?= $user['name']; ?>">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </form>
        </div>
    </div>
</div>