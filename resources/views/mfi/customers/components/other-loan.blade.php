@forelse ($other_loans_details as $loan)
<div class="add-more-field">
    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Company Name<span class="text-danger">*</span></label>
                    
                    <input type="text" class="form-control company" value="{{$loan->company}}" placeholder="Company Name" name="company[]">
                    <input type="hidden" class="form-control other_loan_id" value="{{$loan->id}}" placeholder="Company Name" name="other_loan_id[]">

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Total loan amount<span class="text-danger">*</span></label>
                    <input type="number" class="form-control total_loan_amount"  value="{{$loan->total_loan_amount}}" name="total_loan_amount[]">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Emi frequency<span class="text-danger">*</span></label>
                    <select name="emi_frequency[]" class="emi_frequency">
                        <option value="">Emi frequency</option>
                        <option value="daily" @if($loan->emi_frequency=="daily") {{"selected"}} @endif>
                            Daily
                        </option>
                        <option value="weekly" @if($loan->emi_frequency=="weekly") {{"selected"}} @endif>
                            Weekly
                        </option>
                        <option value="biweekly" @if($loan->emi_frequency=="biweekly") {{"selected"}} @endif>
                            Biweekly
                        </option>
                        <option value="monthly" @if($loan->emi_frequency=="monthly") {{"selected"}} @endif>
                            Monthly
                        </option>
                    </select>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="single-input">
                <div class="form-group">
                    <label>Total Paid Emi<span class="text-danger">*</span></label>
                    <input type="text" class="form-control total_paid_emi"  value="{{$loan->total_paid_emi}}" name="total_paid_emi[]">
                </div>
            </div>
        </div>
    </div>
    <div class="btns-actions-postion">
        <button type="button" class="other-loan-delete-one  m-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
    </div>
</div>
@empty
@endforelse