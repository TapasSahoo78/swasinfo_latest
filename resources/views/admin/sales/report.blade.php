
@extends('admin.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/customer.css') }}">
    {{-- <style>
        .border_amber_300{
            --tw-border-opacity: 1;
            border-color:  rgb(252 211 77 / var(--tw-border-opacity))!important;
        }
    </style> --}}
@endpush
@section('content')
@include('admin.layouts.partials.page-title',['backbutton'=>true])
<!-- Jobs header -->
<div class="flex justify-between items-center mb-4">
    <div class="text-sm text-slate-500 italic">All Addresses 10</div>
</div>

<!-- Job list -->
<div class="space-y-2">
   

</div>
@endsection
@push('scripts')
@endpush
