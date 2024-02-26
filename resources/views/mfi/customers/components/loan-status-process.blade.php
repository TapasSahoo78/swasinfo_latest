<div class="row"> 
    <div class="col-12 col-md-10 hh-grayBox  pb20">
        <div class="row justify-content-between">
            @foreach($loan_process as $key => $value)
            <div class="order-tracking @if($value['is_completed']) completed @endif" style="width:{{$percentage}}%">
                <span class="is-complete"></span>
                <p>{{$value['label']}}<br> @if($value['is_completed']) <span>{{$value['compeleted_date']}}</span> @endif</p>
            </div>
            @endforeach
            <!-- <div class="order-tracking completed">
                <span class="is-complete"></span>
                <p>Shipped<br><span>Tue, June 25</span></p>
            </div>
            <div class="order-tracking">
                <span class="is-complete"></span>
                <p>Delivered<br><span>Fri, June 28</span></p>
            </div>
            <div class="order-tracking">
                <span class="is-complete"></span>
                <p>Delivered<br><span>Fri, June 28</span></p>
            </div> -->
        </div>
    </div>
</div>