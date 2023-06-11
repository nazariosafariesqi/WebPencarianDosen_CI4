<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; JTI Polinema <?= date('Y'); ?></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->

<script src="<?= base_url('assets/'); ?>jquery/jquery.js"></script>
<script src="<?= base_url('assets/'); ?>jquery/jquery.slim.js"></script>

<script src="<?= base_url('assets/'); ?>bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->

<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/scriptEditRouter.js"></script>
<script src="<?= base_url('assets/'); ?>js/script.js"></script>
<script src="<?= base_url('assets/'); ?>js/script2.js"></script>
<script src="<?= base_url('assets/'); ?>js/script3.js"></script>
<script src="<?= base_url('assets/'); ?>js/scriptdelete.js"></script>
<script src="<?= base_url('assets/'); ?>css/pagination.css"></script>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(fileName);
    });
</script>

<a href=" <?= base_url('admin/leases') ?>" id="connectMikrotikBtn" type="button" style="display: none;" class="btn btn-success mb-3">Connect Mikrotik</a>
<script>
    // Fungsi untuk mengklik tombol Connect Mikrotik secara otomatis
    function autoClickConnectMikrotik() {
        var connectMikrotikBtn = document.getElementById('connectMikrotikBtn');
        if (connectMikrotikBtn) {
            connectMikrotikBtn.click();
        }
    }

    // Mengatur tombol Connect Mikrotik terklik otomatis setiap 10 menit saat halaman dimuat
    window.addEventListener('load', function() {
        setInterval(autoClickConnectMikrotik, 600000); // 600000 ms = 10 menit
    });

    // Fungsi untuk menampilkan notifikasi menggunakan alert
    function showAlert(message) {
        alert(message);
    }

    // Fungsi untuk mengklik tombol Connect Mikrotik secara otomatis
    function autoClickConnectMikrotik() {
        var connectMikrotikBtn = document.getElementById('connectMikrotikBtn');
        connectMikrotikBtn.click();

        // Menampilkan notifikasi sedang menghubungkan ke Mikrotik
        showAlert('Sedang menghubungkan ke Mikrotik...');
    }
</script>

</body>

</html>