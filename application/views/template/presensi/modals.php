    <!-- Modal -->
    <div class="modal fade" id="modalLogin" aria-labelledby="modalLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="<?= base_url(); ?>presensi/directLogin" method="POST">
                    <div class="modal-header bg-success text-light">
                        <h5 class="modal-title" id="exampleModalLabel">Login langsung ke Halaman Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>" autofocus>
                        </div>
                        <div class="mb-2">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times-circle me-1"></i>
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-success" id="login" name="login">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMaps" aria-labelledby="modalMapsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="exampleModalLabel">Cek Koordinat GPS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div id="title">Show Position In Map</div>
                    <div id="current">Initializing...</div>
                    <div id="map_canvas" style="width:100%; height:350px"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times-circle me-1"></i>
                        Tutup
                    </button>
                    <button type="button" class="btn btn-primary" onclick="initialize_map();initialize()">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        Reload
                    </button>
                </div>
            </div>
        </div>
    </div>