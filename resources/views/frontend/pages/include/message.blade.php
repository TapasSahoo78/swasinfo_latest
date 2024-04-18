@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" id="errorAlert">
        {{-- {{ session('error') }} --}}
        Vendor created failed
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" id="successAlert" role="alert">
        {{-- {{ session('success') }} --}}
        Vendor created successfullyss
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
