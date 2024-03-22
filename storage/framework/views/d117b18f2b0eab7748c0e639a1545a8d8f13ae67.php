 <!-- jQuery -->
 <script src="<?php echo e(asset('assets/plugins/jquery/jquery.min.js')); ?>"></script>
 <!-- Bootstrap 4 -->
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.0/jquery.toast.min.js" defer></script> 
 <!-- <script src="<?php echo e(asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script> -->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11.6.14/dist/sweetalert2.all.min.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

 <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
 <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

     

 <!-- Brmbmp App -->
 <script src="<?php echo e(asset('assets/js/main.min.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/js/demo.js')); ?>"></script>
 <script src="<?php echo e(asset('assets/admin/js/vendors/alpinejs.min.js')); ?>" defer></script>
<script src="<?php echo e(asset('assets/admin/js/common.js')); ?>" defer></script>

 <script>
     var APP_URL = <?php echo json_encode(url('/')); ?>;
     var TOAST_POSITION = 'bottom-right';


     document.getElementById('shareButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevents the default behavior of the link

    // Get the URL from the button's href attribute
    const url = this.getAttribute('href');

    // Copy the URL to the clipboard
    navigator.clipboard.writeText(url)
        .then(() => {
            alert('URL copied to clipboard!');
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
            // Fallback for unsupported Clipboard API
            const copyFallback = document.createElement('textarea');
            copyFallback.value = url;
            document.body.appendChild(copyFallback);
            copyFallback.select();
            document.execCommand('copy');
            document.body.removeChild(copyFallback);
            alert('URL copied to clipboard!');
        });
});
 </script>
<?php /**PATH C:\xampp\htdocs\webalizer\swasinfo_latest\resources\views/admin/layouts/partials/footer.blade.php ENDPATH**/ ?>