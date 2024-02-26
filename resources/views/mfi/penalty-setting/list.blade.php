@php
    $code = Auth::user()->mfi->code;
@endphp
@extends('mfi.layouts.app')
@push('style')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@section('pagetitlesection')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ Route::currentRouteName() }}" class="nav-link custom-cumb">{{ __('Penalty Setting') }}</a>
    </li>
@endsection
@section('content')
    <div class="content-wrapper p-5">
        <div class="content">
            <section class="container  px-4">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Penalty</h2>
                        <ul id="tabs" class="nav nav-tabs customThemeTab">
                            <li class="nav-item"><a href="#" data-target="#case1" data-toggle="tab"
                                    class="nav-link  active">Case1</a></li>
                            <li class="nav-item"><a href="#" data-target="#case2" data-toggle="tab"
                                    class="nav-link ">Case2</a></li>
                            <li class="nav-item"><a href="#" data-target="#case3" data-toggle="tab"
                                    class="nav-link  ">Case3</a></li>
                        </ul>
                        <br>
                        <div id="tabsContent" class="tab-content">
                            <div id="case1" class="tab-pane fade active show">
                                {{--  <div class="content-wrapper p-5">  --}}
                                <b>Note:</b> <span>If missed emi is recieved before next emi through online mode ( weekly/
                                    biweekly)</span><br><br>
                                <div class="container-fluid">

                                    <div class="profile-update customBorderBox" >
                                        @if(count($listPenaltyCaseOne))
                                        <form method="post" class="penaltyFormsubmit" action="{{ route('mfi.administrator.penalty-setting.list', ['slug' => $code]) }}">
                                            @csrf
                                            @forelse($listPenaltyCaseOne as $key => $penalty)
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="hidden" name="id[]" value="{{ $penalty->id }}" />
                                                        <label>Emi Min Amount <span class="text-danger">*</span></label>
                                                        <input id="min_amount_{{ $key }}" class="form-control" type="text"
                                                            name="min_amount[]" placeholder="Min Amount"
                                                            value="{{ $penalty->min_amount }}" />
                                                       
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Emi Max Amount <span class="text-danger">*</span></label>
                                                        <input id="max_amount_{{ $key }}" class="form-control" type="text"
                                                            name="max_amount[]" placeholder="Max Amount"
                                                            value="{{ $penalty->max_amount }}" />
                                                       
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Penalty Amount <span class="text-danger">*</span></label>
                                                        <input id="penalty_amount_{{ $key }}" class="form-control" type="text"
                                                            name="penalty_amount[]" placeholder="Penalty Amount"
                                                            value="{{ $penalty->penalty_amount }}" />
                                                       
                                                    </div>

                                                </div>
                                            @empty
                                            @endforelse
                                            @if(count($listPenaltyCaseOne))
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="submit" value="Update">
                                                </div>
                                            </div>
                                            @endif
                                        </form>
                                        @endif
                                        <form method="post"
                                            action="{{ route('mfi.administrator.penalty-setting.case-list-save', ['slug' => $code]) }}"
                                         class="formsubmit">
                                            @csrf
                                            <div class="row">
                                                <div class="col-4">
                                                    <input type="hidden" name="case_type" value="1" />
                                                    <input type="hidden" name="penalty_type" value="flat" />
                                                    <label>Emi Min Amount <span class="text-danger">*</span></label>
                                                    <input id="min_amount" class="form-control" type="text"
                                                        name="min_amount" placeholder="Min Amount" value="" />
                                                    
                                                </div>
                                                <div class="col-4">
                                                    <label>Emi Max Amount <span class="text-danger">*</span></label>
                                                    <input id="max_amount" class="form-control" type="text"
                                                        name="max_amount" placeholder="Max Amount" value="" />
                                                  
                                                </div>
                                                <div class="col-4">
                                                    <label>Penalty Amount <span class="text-danger">*</span></label>
                                                    <input id="penalty_amount" class="form-control" type="text"
                                                        name="penalty_amount" placeholder="Penalty Amount"
                                                        value="" />
                                                    
                                                </div>
                                                <div class="col-6">
                                                    <input type="submit" value="Add">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                {{--  </div>  --}}
                            </div>
                            <div id="case2" class="tab-pane fade ">
                                {{--  <div class="content-wrapper p-5">  --}}
                                <b>Note:</b> <span>If missed emi is recieved combined with next scheduled emi ( in any
                                    mode)</span><br><br>
                                <div class="container-fluid">

                                   <div class="profile-update customBorderBox" >
                                   @if(count($listPenaltyCaseTwo))
                                        <form method="post" class="penaltyCaseTwoFormsubmit" action="{{ route('mfi.administrator.penalty-setting.case2-list', ['slug' => $code]) }}">
                                            @csrf
                                            @forelse($listPenaltyCaseTwo as $key => $penalty)
                                                <div class="row">
                                                    <div class="col-4">
                                                        <input type="hidden" name="p_id[]" value="{{ $penalty->id }}" />
                                                        <label>Emi Min Amount <span class="text-danger">*</span></label>
                                                        <input id="minimum_amount_{{ $key }}" class="form-control" type="text"
                                                            name="minimum_amount[]" placeholder="Min Amount"
                                                            value="{{ $penalty->min_amount }}" />
                                                       
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Emi Max Amount <span class="text-danger">*</span></label>
                                                        <input id="maximum_amount_{{ $key }}" class="form-control" type="text"
                                                            name="maximum_amount[]" placeholder="Max Amount"
                                                            value="{{ $penalty->max_amount }}" />
                                                       
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Penalty Amount <span class="text-danger">*</span></label>
                                                        <input id="penaltywise_amount_{{ $key }}" class="form-control" type="text"
                                                            name="penaltywise_amount[]" placeholder="Penalty Amount"
                                                            value="{{ $penalty->penalty_amount }}" />
                                                       
                                                    </div>

                                                </div>
                                            @empty
                                            @endforelse
                                            @if(count($listPenaltyCaseTwo))
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="submit" value="Update">
                                                </div>
                                            </div>
                                            @endif
                                        </form>
                                        @endif
                                        <form method="post"
                                            action="{{ route('mfi.administrator.penalty-setting.case2-list-save', ['slug' => $code]) }}"
                                         class="formsubmit">
                                            @csrf
                                            <div class="row">
                                                <div class="col-4">
                                                    <input type="hidden" name="casetwo_type" value="2" />
                                                    <input type="hidden" name="penaltywise_type" value="flat" />
                                                    <label>Emi Min Amount <span class="text-danger">*</span></label>
                                                    <input id="minimum_amount" class="form-control" type="text"
                                                        name="minimum_amount" placeholder="Min Amount" value="" />
                                                    {{--  @error('min_amount')
                                                        <span class="text-sm mt-1 text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror  --}}
                                                </div>
                                                <div class="col-4">
                                                    <label>Emi Max Amount <span class="text-danger">*</span></label>
                                                    <input id="maximum_amount" class="form-control" type="text"
                                                        name="maximum_amount" placeholder="Max Amount" value="" />
                                                   {{--   @error('max_amount')
                                                        <span class="text-sm mt-1 text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror  --}}
                                                </div>
                                                <div class="col-4">
                                                    <label>Penalty Amount <span class="text-danger">*</span></label>
                                                    <input id="penaltywise_amount" class="form-control" type="text"
                                                        name="penaltywise_amount" placeholder="Penalty Amount"
                                                        value="" />
                                                    {{--  @error('penalty_amount')
                                                        <span class="text-sm mt-1 text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror  --}}
                                                </div>
                                                <div class="col-6">
                                                    <input type="submit" value="Add">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                {{--  </div>  --}}
                            </div>
                            <div id="case3" class="tab-pane fade">
                                {{--   <div class="content-wrapper p-5">  --}}
                                <b>Note:</b> <span>If emi is shifted to the last of the loan, in this case loan installment
                                    and
                                    time will be increased
                                    ( if there are 14 weeks tenure, it will increase to 15 weeks same as no of
                                    emi)</span><br><br>
                                <div class="container-fluid">
                                    <div class="profile-update">
                                        <form method="post"
                                            action="{{ route('mfi.administrator.penalty-setting.case3-list', ['slug' => $code]) }}" class="formsubmit">
                                            @csrf
                                            <div class="row">
                                                <div class="col-4">
                                                    <input type="hidden" name="ptype" value="%" />
                                                    <input type="hidden" name="ctype" value="3" />
                                                    <input type="hidden" name="penalty_id" value="{{count($listPenaltyCaseThree) ?  $listPenaltyCaseThree[0]['id'] :'' }}">
                                                    <label>Penalty Amount <span class="text-danger">*</span> <span>( %
                                                            )</span></label>
                                                    <input id="amount" class="form-control" type="text"
                                                        name="amount" placeholder="Penalty Amount"
                                                        value="{{ count($listPenaltyCaseThree) ?  $listPenaltyCaseThree[0]['penalty_amount'] :'' }}"
                                                         />
                                                   
                                                </div><br><br>
                                                <div class="col-12">
                                                    <input type="submit" value="Update">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{--  </div>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Content Wrapper. Contains page content -->

        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#addbranch-btn").click(function() {
                $("#slide-from-right").addClass("show-side-form");
            });

            $("#close-btn").click(function() {
                $("#slide-from-right").removeClass("show-side-form");
            });
        });
    </script>
    <script src="{{ asset('assets/admin/js/penalty.js') }}"></script>
@endpush
