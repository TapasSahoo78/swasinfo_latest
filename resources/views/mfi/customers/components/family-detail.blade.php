@forelse ($family_details as $family)
<div class="add-more-field">
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Member name<span class="text-danger">*</span></label>
                    
                    <input type="hidden" class="form-control member_id" value="{{$family->id}}" placeholder="Member Name" name="member_id[]">
                    <input type="text" class="form-control member_name" value="{{$family->member_name}}" placeholder="Member Name" name="member_name[]">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Age<span class="text-danger">*</span></label>
                    <input type="Number" class="form-control age" placeholder="age" value="{{$family->age}}" name="age[]">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Relation<span class="text-danger">*</span></label>
                    <select name="relation[]" class="relation">
                        <option value="">Relation</option>
                        <option value="father" @if($family->relation=='father') {{"selected"}} @endif>
                            Father
                        </option>
                        <option value="mother" @if($family->relation=='mother') {{"selected"}} @endif>
                            Mother
                        </option>
                        <option value="brother" @if($family->relation=='brother') {{"selected"}} @endif>
                            Brother
                        </option>
                        <option value="sister" @if($family->relation=='sister') {{"selected"}} @endif>
                            Sister
                        </option>
                        <option value="father_in_law" @if($family->relation=='father_in_law') {{"selected"}} @endif>
                            Father In Law
                        </option>
                        <option value="mother_in_law" @if($family->relation=='mother_in_law') {{"selected"}} @endif>
                            Mother In Law
                        </option>
                        <option value="sister_in_law" @if($family->relation=='sister_in_law') {{"selected"}} @endif>
                            Sister In Law
                        </option>
                        <option value="brother_in_law" @if($family->relation=='brother_in_law') {{"selected"}} @endif>
                            Brother In Law
                        </option>
                    </select>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Occupation<span class="text-danger">*</span></label>
                    <select name="occupation_id[]" class="occupation_id">
                        <option value="">Select Occupation</option>
                        @forelse ($listOccupation as $occupation)
                        <option value="{{ $occupation->id }}" @if($family->occupation_id==$occupation->id) {{"selected"}} @endif  data-id="{{ $occupation->uuid }}">
                            {{ !empty($occupation->name) ? $occupation->name : '' }}
                        </option>
                        @empty
                        <option value="" data-id="">
                            {{ 'No Occupations Available' }}
                        </option>
                        @endforelse
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="btns-actions-postion">
        <button type="button" class="family-delete-one  m-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
    </div>
</div>
@empty
@endforelse
