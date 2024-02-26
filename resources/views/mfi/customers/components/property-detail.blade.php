@forelse ($property_details as $property)

<div class="add-more-field">
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Property Type<span class="text-danger">*</span></label>
                    <select name="property_type[]" class="property_type">
                        <option value="">Property Type</option>
                        <option value="public" @if($property->property_type=="public") {{"selected"}} @endif  >
                            Public
                        </option>
                        <option value="private" @if($property->property_type=="private") {{"selected"}} @endif>
                            Private
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Property condition<span class="text-danger">*</span></label>
                    <select name="property_condition[]" class="property_condition">
                        <option value="">Property condition</option>
                        <option value="own" @if($property->property_condition=="own") {{"selected"}} @endif>
                            Own
                        </option>
                        <option value="rented" @if($property->property_condition=="rented") {{"selected"}} @endif>
                            Rented
                        </option>
                    </select>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Year<span class="text-danger">*</span></label>
                    <input type="year" class="form-control year" value="{{$property->year}}" name="year[]">
                    <input type="hidden" class="form-control property_id" value="{{$property->id}}" name="property_id[]" >
                </div>
            </div>
        </div>

    </div>
    <div class="btns-actions-postion">
        <button class="property-delete-one  m-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
    </div>
</div>
@empty
@endforelse