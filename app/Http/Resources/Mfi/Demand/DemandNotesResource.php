<?php

namespace App\Http\Resources\Mfi\Demand;

use Illuminate\Http\Resources\Json\JsonResource;

class DemandNotesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
                $cont_loan_process =[
                'pending'=>['label'=>"Pending",'value'=>1,'is_fixed'=>true,'is_completed'=>true,'compeleted_date'=>date('d-m-Y'),'bg_color'=>'bg-warning'],
                'on_hold'=>['label'=>"On Hold",'value'=>4,'is_fixed'=>false,'is_completed'=>false,'compeleted_date'=>date('d-m-Y'),'bg_color'=>'bg-warning'],
                'rejected'=>['label'=>"Rejected",'value'=>0,'is_fixed'=>false,'is_completed'=>false,'compeleted_date'=>date('d-m-Y'),'bg_color'=>'bg-warning'],
                'withdrawal'=>['label'=>"Withdrawal",'value'=>3,'is_fixed'=>false,'is_completed'=>false,'compeleted_date'=>date('d-m-Y'),'bg_color'=>'bg-warning'],
                'approved'=>['label'=>"Approved /Disbursement Pending",'value'=>2,'is_fixed'=>true,'is_completed'=>false,'compeleted_date'=>date('d-m-Y'),'bg_color'=>'bg-warning']
                ];
                $disbursement_process = [
                    // 'disbursement_pending'=>['label'=>"Disbursement Pending",'value'=>0,'is_fixed'=>true,'is_completed'=>false,'compeleted_date'=>date('d-m-Y')],
                    'disbursed'=>['label'=>"Disbursed",'value'=>1,'is_fixed'=>true,'is_completed'=>false,'compeleted_date'=>date('d-m-Y'),'bg_color'=>'bg-warning']
                ];
                $final_loan_process=[];
                $demandedStatus = array_column(($this->demandNotes->toArray()),'demand_status');
                $disbursement_status = array_column(($this->demandNotes->toArray()),'disbursement_status');
                foreach($cont_loan_process as $key => $value)
                {
                    if((in_array($value['value'],$demandedStatus)) ||  ($value['is_fixed']==true))
                    {
                        if((in_array($value['value'],$demandedStatus)))
                        {
                            $created_at = $this->demandNotes->where('demand_status',$value['value'])->first();
                            $created_date = !empty($created_at) ? date('d M Y',strtotime($created_at->created_at)) :"";
                            // echo $created_at;
                            $value['is_completed']= true;
                            $value['compeleted_date']=$created_date;
                        }
                        $final_loan_process[] = $value; 
                    }
                }
                foreach($disbursement_process as $keyD => $valueD)
                {
                    if((in_array($valueD['value'],$disbursement_status)))
                    {
                        $created_at = $this->demandNotes->where('disbursement_status',$valueD['value'])->first();
                        $created_date = !empty($created_at) ? date('d M Y',strtotime($created_at->created_at)) :"";
                        $valueD['is_completed']= true;
                        $valueD['compeleted_date']= $created_date;
                    }
                    $final_loan_process[] = $valueD; 
                }
            $percentage = round(100/count($final_loan_process),2);
        return [
            'demand_id' => $this->id,
            // 'uuid' => $this->uuid,
            'demand_status' => $this->demand_status,
            'disbursement_status' => $this->disbursement_status,
            'demand_notes'=> $this->demandNotes,
            'final_loan_process'=>$final_loan_process,
            'loan_status_process'=> view('mfi.customers.components.loan-status-process')->with(['percentage' => $percentage,'loan_process'=>$final_loan_process])->render()

            /* 'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount, */
        ];
    }
}


