@php
    $success = Session::get('success');
    $errors = Session::get('error');
    $info = Session::get('info');
    $warnings = Session::get('warning');
@endphp

@if($success)
    @foreach($success as $key => $value)
        <span class="flashstatus d-none">SUCCESS</span>
        <span class="flashmessage d-none">{{ $value }}</span>
    @endforeach
@endif

@if(session('status'))
    <span class="flashstatus d-none">SUCCESS</span>
    <span class="flashmessage d-none">{{ session('status') }}</span>
@endif


@if ($errors)
	@foreach($errors as $key => $value)
        <span class="flashstatus d-none">ERROR</span>
        <span class="flashmessage d-none">{{ $value }}</span>
	@endforeach
@endif

@if ($info)
	@foreach($info as $key => $value)
        <span class="flashstatus d-none">INFORMATION</span>
        <span class="flashmessage d-none">{{ $value }}</span>
	@endforeach
@endif

@if ($warnings)
	@foreach($warnings as $key => $value)
        <span class="flashstatus d-none">WARNING</span>
        <span class="flashmessage d-none">{{ $value }}</span>
	@endforeach
@endif
