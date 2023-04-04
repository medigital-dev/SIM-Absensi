<div class="row">
    <div class="col-md-4 mx-auto mt-3">
        <div class="card shadow border-danger">
            <div class="card-body text-danger text-center">
                <p>
                    <i class="fas fa-hand-paper fa-4x"></i>
                <h4>
                    <strong>
                        Directory access is forbidden.
                    </strong>
                </h4>
                Level User Anda: <?= $_SESSION['user']['level_user']; ?>.<br>
                User ini tidak diperkenankan untuk mengakses halaman ini!
                </p>
                <a href="<?= base_url(); ?>admin" class="btn btn-primary"><i class="fas fa-tachometer-alt fa-fw mr-1"></i> Dashboard</a>
            </div>
        </div>
    </div>
</div>