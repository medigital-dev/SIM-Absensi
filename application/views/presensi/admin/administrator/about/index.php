<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="data-tanggal" data-flashdata="<?= $this->session->flashdata('tanggal'); ?>"></div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tentang Kami</h1>
        <button type="button" onClick="window.location.reload();" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-sync-alt fa-fw fa-sm"></i>Reload</button>
    </div>

    <div class="card shadow mb-3">
        <div class="card-body">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Tentang Kami
                            </button>
                        </h2>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            Aplikasi ini dibuat dan dikembangkan mulai bulan Juli tahun 2021 oleh Muhammad Said Latif Ghofari.
                            Versi pertama dari aplikasi ini diluncurkan pada pertengah bulan Agustus tahun 2021.
                            Pengembang sangat terbuka terhadap ide, kritik dan ataupun saran dari pengguna sehingga aplikasi ini terus berkembang dan memenuhi kebutuhan pengguna.<br>
                            <strong>Sampaikan ide, kritik dan atau saran anda pada bagian Kontak.</strong>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Tentang Aplikasi
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <h5>ePresensi</h5>
                            <h6>Version: 1.0</h6>
                            <strong>Fitur:</strong>
                            <ul>
                                <li>Base CodeIgniter 3</li>
                                <li>SB Admin 2</li>
                                <li>Menu</li>
                                <ul>
                                    <li>Landing Page: Presensi</li>
                                    <li>Dashboard</li>
                                    <li>Log Presensi</li>
                                    <li>Laporan Kehadiran</li>
                                    <ul>
                                        <li>Rici</li>
                                        <li>Rekapitulasi</li>
                                    </ul>
                                    <li>Data Pengguna</li>
                                    <ul>
                                        <li>Ganti Password</li>
                                    </ul>
                                    <li>Administrator</li>
                                    <ul>
                                        <li>Data Pegawai</li>
                                        <ul>
                                            <li>Daftar Pegawai</li>
                                            <li>Tambah Pegawai</li>
                                            <li>Detail Pegawai</li>
                                            <li>Edit Pegawai</li>
                                            <li>Aktif/Non Aktifkan Pegawai</li>
                                            <li>Reset Password Pegawai</li>
                                            <li>Delete Pegawai</li>
                                        </ul>
                                        <li>Kehadiran Pegawai</li>
                                        <ul>
                                            <li>Lihat Presensi</li>
                                            <ul>
                                                <li>Edit/Hapus Presensi</li>
                                            </ul>
                                            <li>Laporan Kehadiran</li>
                                            <ul>
                                                <li>Rinci</li>
                                                <li>Rekap</li>
                                                <li>Individu</li>
                                            </ul>
                                            <li>Absensi Pegawai</li>
                                            <ul>
                                                <li>Tambah</li>
                                                <li>Edit</li>
                                                <li>Hapus</li>
                                            </ul>
                                        </ul>
                                        <li>Pengaturan</li>
                                        <ul>
                                            <li>Perusahaan</li>
                                            <ul>
                                                <li>Profil</li>
                                                <li>Logo</li>
                                                <li>Pejabat</li>
                                            </ul>
                                            <li>Presensi</li>
                                            <ul>
                                                <li>Jam Kerja</li>
                                                <li>Tahun Aktif</li>
                                            </ul>
                                        </ul>
                                        <li>About Us</li>
                                    </ul>
                                </ul>
                            </ul>
                            <h5>Changelog</h5>
                            <h6><i>Version: 1.0</i></h6>
                            <h6>
                                Release date: <b><i>16 Agustus 2021</i></b>
                            </h6>
                            <ul>
                                <li>First release</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwoo" aria-expanded="false" aria-controls="collapseTwoo">
                                Ketentuan Penggunaan
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwoo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            Aplikasi ini menjadi milik anda sebagai pengguna, anda dapat merubah, menambah maupun mengurangi bagian dalam aplikasi ini. Segala bentuk akibat dari perubahan tersebut sepenuhnya menjadi tanggungjawab anda.
                            Jika anda terdapat kesulitan maupun request, jangan ragu untuk menghubungi kami.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Kontak Kami
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                        <div class="card-body">
                            <table class="table table-borderless table-sm table-hover">
                                <tr>
                                    <td style="width: 150px;">Nama</td>
                                    <td>Muhammad Said Latif Ghofari</td>
                                </tr>
                                <tr>
                                    <td>Telepon</td>
                                    <td>087839301572</td>
                                </tr>
                                <tr>
                                    <td>FB, TW, IG</td>
                                    <td>@mesaidlg</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>mesaidlg@gmail.com</td>
                                </tr>
                                <tr>
                                    <td>Website</td>
                                    <td>me-digital.net</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->