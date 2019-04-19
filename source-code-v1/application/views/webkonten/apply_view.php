<br>
<div class="container">

<form class="form-horizontal" id="form_input" method=POST enctype='multipart/form-data'>

    <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">

    <input type='hidden' class='form-control' name='id_posisi' value="<?php echo $w_posisi_detail['id'];?>">

    

    <br>
    <h4 class="page-header">Posisi yang dilamar : <?php echo $w_posisi_detail['nama_posisi'];?></h4>

    <hr>

    <h4 class="page-header">Biodata</h4>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nomor KTP <span style="color:red">*</span></label>
                <div>
                    <input type="text" name="nomor_ktp" maxlength="16" onkeypress='validate(event)' id="nomor_ktp" class="form-control form-control-sm" placeholder="Nomor KTP" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat Lahir <span style="color:red">*</span></label>
                        <div>
                            <input type="text"  name="tempat_lahir" id="tempat_lahir" class="form-control form-control-sm" placeholder="Tempat Lahir" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control form-control-sm" placeholder="Tanggal Lahir" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin <span style="color:red">*</span></label>
                        <select class="form-control form-control-sm" id="jenis_kelamin" name="jenis_kelamin">
        <option value="0">-Pilih-</option>
        <option value="L">Laki-Laki</option>
        <option value="P">Perempuan</option>
      </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nomor Handphone <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="nomor_hp" id="nomor_hp" class="form-control form-control-sm" placeholder="Nomor Handphone" />
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Lengkap <span style="color:red">*</span></label>
                <div>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control form-control-sm" placeholder="Nama Lengkap" />
                </div>
            </div>
            <div class="form-group">
                <label>Nama Ibu Kandung <span style="color:red">*</span></label>
                <div>
                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control-sm" placeholder="Nama Ibu Kandung" />
                </div>
            </div>
            <div class="form-group">
                <label>Alamat E-mail <span style="color:red">*</span></label>
                <div>
                    <input type="text" name="email" id="email" class="form-control form-control-sm" placeholder="Alamat Email" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-md-12">
                <label>Alamat Lengkap <span style="color:red">*</span></label>
                <input type="text" name="alamat_lengkap" id="alamat_lengkap" class="form-control form-control-sm" placeholder="Alamat Lengkap" />
            </div>
        </div>
        <br>

    <h4 class="page-header">Pendidikan Terakhir</h4>
    <hr>

    <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenjang Pendidikan <span style="color:red">*</span></label>
                        <select class="form-control form-control-sm" id="jenjang_pendidikan" name="jenjang_pendidikan">
        <option value="0">-Pilih-</option>
        <option value="SMA">SMA</option>
        <option value="D3">D3</option>
        <option value="S1">S1</option>
        <option value="S2">S2</option>
      </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Sekolah / Perguruan Tinggi <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control form-control-sm" placeholder="Nama Sekolah / Perguruan Tinggi" />
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fakultas <span style="color:red">*</span></label>
                        <input type="text" name="fakultas" id="fakultas" class="form-control form-control-sm" placeholder="Fakultas" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Akreditasi<span style="color:red">*</span></label>
                        <div>
                            <select class="form-control form-control-sm" id="akreditasi" name="akreditasi">
                                <option value="0">-Pilih-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                              </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>IPK <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="ipk" id="ipk" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jurusan / Program Studi <span style="color:red">*</span></label>
                        <input type="text" name="jurusan" id="jurusan" class="form-control form-control-sm" placeholder="Jurusan / Program Studi" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tahun Masuk<span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="tahun_masuk" id="tahun_masuk" class="form-control form-control-sm" />
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tahun Keluar <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="tahun_keluar" id="tahun_keluar" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
            </div>



        <h4 class="page-header">Pengalaman Kerja 1</h4>
        <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Perusahaan <span style="color:red">*</span></label>
                        <input type="text" name="nama_perusahaan_1" id="nama_perusahaan_1" class="form-control form-control-sm" placeholder="Nama Perusahaan" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Kantor <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="alamat_perusahaan_1" id="alamat_perusahaan_1" class="form-control form-control-sm" placeholder="Alamat Kantor" />
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Posisi Terakhir <span style="color:red">*</span></label>
                        <input type="text" name="posisi_terakhir_1" id="posisi_terakhir_1" class="form-control form-control-sm" placeholder="Posisi Terakhir" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tahun Masuk<span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="tahun_masuk_kerja_1"  id="tahun_masuk_kerja_1" class="form-control form-control-sm" />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tahun Keluar <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="tahun_keluar_kerja_1" id="tahun_keluar_kerja_1" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Gaji Terakhir<span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="gaji_terakhir_kerja_1" id="gaji_terakhir_kerja_1" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Job Desc Pekerjaan <span style="color:red">*</span></label>
                        <textarea name="job_pekerjaan_1" id="job_pekerjaan_1" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
            </div>



    <h4 class="page-header">Pengalaman Kerja 2</h4>
    <hr>

                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Perusahaan <span style="color:red">*</span></label>
                        <input type="text" name="nama_perusahaan_2" id="nama_perusahaan_2" class="form-control form-control-sm" placeholder="Nama Perusahaan" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alamat Kantor <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="alamat_perusahaan_2" id="alamat_perusahaan_2" class="form-control form-control-sm" placeholder="Alamat Kantor" />
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Posisi Terakhir <span style="color:red">*</span></label>
                        <input type="text" name="posisi_terakhir_2" id="posisi_terakhir_2" class="form-control form-control-sm" placeholder="Posisi Terakhir" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tahun Masuk<span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="tahun_masuk_kerja_2"  id="tahun_masuk_kerja_2" class="form-control form-control-sm" />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tahun Keluar <span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="tahun_keluar_kerja_2" id="tahun_keluar_kerja_2" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Gaji Terakhir<span style="color:red">*</span></label>
                        <div>
                            <input type="text" name="gaji_terakhir_kerja_2" id="gaji_terakhir_kerja_2" class="form-control form-control-sm"/>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Job Desc Pekerjaan <span style="color:red">*</span></label>
                        <textarea name="job_pekerjaan_2" id="job_pekerjaan_2" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>CV Pdf <span style="color:red">*</span></label>
                        <input type="file" id="file_cv" name="file_cv">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>

           
        </form>
    </div>



