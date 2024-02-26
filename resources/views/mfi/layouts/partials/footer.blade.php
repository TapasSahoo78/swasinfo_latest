 <!-- jQuery -->
 <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
 <!-- Bootstrap 4 -->
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.0/jquery.toast.min.js" defer></script> 
 <!-- <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> -->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11.6.14/dist/sweetalert2.all.min.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 <!-- Brmbmp App -->
 <script src="{{ asset('assets/js/main.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo.js') }}"></script>
 <script src="{{ asset('assets/admin/js/vendors/alpinejs.min.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/common.js') }}" defer></script>
 <script>
     var APP_URL = {!! json_encode(url('/')) !!};
     var TOAST_POSITION = 'bottom-right';
 </script>
