
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
    <div class="text-sm text-slate-500 italic">All Addresses ({{$addreses->count()}})</div>
</div>

<!-- Job list -->
<div class="space-y-2">
    @forelse ($addreses as $address)
        <div class="{{  $address->is_default ? 'bg-amber-50' : 'bg-white' }} shadow-lg rounded-sm border {{  $address->is_default ? 'border-amber-300' : 'border-slate-200' }} px-5 py-4">
            <div class="md:flex justify-between items-center space-y-4 md:space-y-0 space-x-2">
                <!-- Left side -->
                <div class="flex items-start space-x-3 md:space-x-4">
                    <div class="w-9 h-9 shrink-0 mt-1">
                        @switch($address->type)
                            @case('home')
                                @php $file= asset('assets/images/home.png') @endphp
                                @break
                            @case('office')
                                @php $file= asset('assets/images/office.jpg') @endphp
                                @break
                            @default
                                @php $file= asset('assets/images/other.png') @endphp
                        @endswitch
                        <img class="w-9 h-9 rounded-full" src="{{ $file }}" width="36" height="36" alt="Company 05" />
                    </div>
                    <div>
                        <a class="inline-flex font-semibold text-slate-800" href="Javascript:void(0)">{{ $address->name }}</a>
                        <div class="text-sm">{{ $address->full_address['address_line_two'].','.$address->zip_code }}</div>
                    </div>
                </div>
                <!-- Right side -->
                <div class="flex items-center space-x-4 pl-10 md:pl-0">
                    <div class="text-sm text-slate-500 italic whitespace-nowrap">{{ \Carbon\carbon::parse($address->created_at)->format('M d') }}</div>
                    @switch($address->type)
                        @case('office')
                            <div class="text-xs inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-1">Office</div>
                            @break
                        @case('home')
                        <div class="text-xs inline-flex font-medium bg-emerald-100 text-emerald-600 rounded-full text-center px-2.5 py-1">Home</div>
                            @break
                        @default
                        <div class="text-xs inline-flex font-medium bg-amber-100 text-amber-600 rounded-full text-center px-2.5 py-1">Other</div>
                    @endswitch

                    <div class="m-1.5">
                        <!-- Start -->
                        <a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            href="{{ route('admin.customer.update.address', $address->uuid) }}">
                            <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                            </svg>
                        </a>
                        <!-- End -->
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-amber-50 shadow-lg rounded-sm border border-amber-300 px-5 py-4">
            No Address added Yet
        </div>
    @endforelse
    <!-- Job 1 -->
    @include('admin.layouts.paginate',['paginatedCollection'=>$addreses])

</div>
@endsection
@push('scripts')
@endpush
