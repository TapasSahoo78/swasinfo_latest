{{--  <div class="login-footer">
                <p>Copyrights &#169; {{date('Y')}} Silvercoin. All Rights Reserved.</p>

</div>  --}}
 <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
<!-- <script src="//cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.0/jquery.toast.min.js" integrity="sha512-zv5L1hY+PMayrX2l0ojsUqem6AHpdSIVyDJBlDQH/fMLpH1JgaxPTjpum1b1AlLHdARVonrpomps+GgR0oN3MA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}" defer></script>
<script src="//jqueryvalidation.org/files/dist/additional-methods.min.js" defer></script>
<script src="{{ asset('assets/admin/js/vendors/alpinejs.min.js') }}" defer></script>
<script src="{{ asset('assets/admin/js/common.js') }}" defer></script>
<script>
    var APP_URL = {!! json_encode(url('/')) !!};
    var TOAST_POSITION = 'bottom-right';
</script>
{{--  <script  src="{{ asset('assets/auth/auth.js') }}" defer></script>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('captcha.sitekey') }}" defer></script>  --}}

@stack('scripts')
