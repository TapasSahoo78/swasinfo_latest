<?php
namespace App\Http\Controllers\Api\Trainer;
use random;
// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainerDetail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use App\Services\Trainer\TrainerService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\Trainer\TrainerDetailApiCollection;

class TrainerApiController extends BaseController
{
    protected $trainerService;
    public function __construct(TrainerService $trainerService)
    {
        $this->trainerService = $trainerService;
    }

    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password'=>'required|string|min:6',
            'username' =>'required|nullable|string',
            'is_email'=>'required|boolean'
        ]);

        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,200,$validator->errors()->first(),"");
        }
        try{
        if($request->is_email)
        {
            $request->merge(['email'=>$request->username]);
            $userFound = $this->trainerService->findUserByEmail($request->username);
        }
        else
        {
            $request->merge(['mobile_number'=>$request->username]);
            $userFound = $this->trainerService->findUserByMobile($request->username);
        }

        if(!empty($userFound))
        {
            return $this->responseJson(false,200,"You have already registered","");
        }

        $otp = genrateOtp(4);
        $request->merge(['verification_code'=>$otp]);
        $request->merge(['password'=>$request->password]);

        $userExist = $this->trainerService->createOrUpdateCustomer($request->except('_token'),$userFound?->id ?? NULL);

        if ($userExist)
        {
            $userData=['otp'=>$otp];
            $message = "OTP send successfully !!";
            return $this->responseJson(true, 200,$message,$userData);
        }
         else
         {
            $message = "user not found";
            return $this->responseJson(false,401,$message,"");
        }
    }catch(\Exception $e)
    {
        return $this->responseJson(false, 500,$e->getMessage().'--'.$e->getFile().'--'.$e->getLine());
    }

    }


    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp'=>'required|numeric|digits:4',
            'username' =>'required|nullable|string',
            'is_email'=>'required|boolean'
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,200,$validator->errors()->first(),"");
        }
        if($request->is_email)
        {
            $request->merge(['email'=>$request->username]);
            $userFound = $this->trainerService->findUserByEmail($request->username);
        }else
        {
            $request->merge(['mobile_number'=>$request->username]);
            $userFound = $this->trainerService->findUserByMobile($request->username);
        }
        if(is_null($userFound)){
            return $this->responseJson(false, 200,"User Not Found","");
        }
        //return $userFound;
        if($request->otp!=$userFound->verification_code)
        {
            return $this->responseJson(false,200,"OTP not matched","");
        }else{
            $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
            $userData=['otp_matched'=>true,
            'user_details'=>$userFound
        ];
            $message = "OTP  Validated !!";
            return $this->responseJson(true, 200,$message,$userData);
        }

    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'=>'required|string|min:6',
            'username' =>'required|nullable|string',
            'is_email'=>'required|boolean'
        ]);
        if ($validator->fails()) {
            $error=['error' => $validator->errors()->all()];
            return $this->responseJson(false,200,$validator->errors()->first(),"");
        }
        if($request->is_email)
        {
            $loginParam= ['email'=>$request->username];
        }else
        {
            $loginParam= ['mobile_number'=>$request->username];
        }
        $loginParam['password']=$request->password;
        if(auth()->attempt($loginParam))
        {
           $otp = genrateOtp(4);
           $user= auth()->user();
            $otpupdate = $user->update([
                        'verification_code'=>$otp
            ]);
            if($otpupdate) {
            $userData=[
            'otp'=>$otp
            ];
            $message = "OTP  Sent Successfully !!";
            return $this->responseJson(true, 200, $message, $userData);
            }
        }
        else{
            return $this->responseJson(false,200,"Wrong login details","");
        }
    }


    public function loginVerify(Request $request){

        $validator = Validator::make($request->all(), [
             'otp'=>'required|numeric|digits:4',
             'username' =>'required|nullable|string',
             'is_email'=>'required|boolean'
         ]);
         if ($validator->fails()) {
             $error=['error' => $validator->errors()->all()];
             return $this->responseJson(false,200,$validator->errors()->first(),"");
         }
         if($request->is_email)
         {
             $request->merge(['email'=>$request->username]);
             $userFound = $this->trainerService->findUserByEmail($request->username);
         }else
         {
             $request->merge(['mobile_number'=>$request->username]);
             $userFound = $this->trainerService->findUserByMobile($request->username);
         }
         if(is_null($userFound)){
             return $this->responseJson(false, 200,"User Not Found","");
         }
         //return $userFound;
         if($request->otp!=$userFound->verification_code)
         {
             return $this->responseJson(false,200,"OTP not matched","");
         }else{
             $userFound->access_token = $userFound->createToken('LaravelAuthApp')->accessToken;
             $userData=['otp_matched'=>true,
             'user_details'=>$userFound
         ];
             $message = "LoggedIn Successfully !!";
             return $this->responseJson(true, 200,$message,$userData);
         }
     }


     public function createProfile(Request $request)
     {
        $userId = auth()->user()->id;
           $validator = Validator::make($request->all(), [
           'name' => 'required|string',
           'gender' => 'nullable|string',
           'age' => 'nullable|string',

           'preffered_language' => 'nullable|string',
           'expertise' => 'nullable|numeric',
           'qualification_name' => 'nullable|string',

           'intro' => 'nullable|string',
           'ac_no' => 'nullable|numeric',
           'reenter_ac_no' => 'nullable|numeric|same:ac_no',
           'ifsc_code' => 'nullable|string',
           'bank_name' => 'nullable|string',

           ]);
           if ($validator->fails()) {
               $error=['error' => $validator->errors()->all()];
               return $this->responseJson(false,200,$validator->errors()->first(),"");
           }





            // $preffered_language=$request->preffered_language;
            // $expertise=$request->expertise;
            // $qualification_name=$request->qualification_name;
            // $intro=$request->intro;
            // $ac_no=$request->ac_no;
            // $reenter_ac_no=$request->reenter_ac_no;
            // $ifsc_code=$request->ifsc_code;
            // $bank_name=$request->bank_name;
            // dd($request->all());

            // $base64Image_for_profile="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";
            // $base64Image_for_qualification="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";
            // $base64Image_for_bank_cheque="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";
            // $base64Image_for_id_proof="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";



            //$base64Image_for_id_proof="iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8DwABAwAD/wAAA";

            $base64Image_for_profile=$request->profile_picture_file;
            $base64Image_for_qualification=$request->qualification_file;
            $base64Image_for_bank_cheque=$request->bank_check_file;
            $base64Image_for_id_proof=$request->id_proof_file;


            $decodedImage_for_profile = base64_decode($base64Image_for_profile);
            $decodedImage_for_qualification = base64_decode($base64Image_for_qualification);
            $decodedImage_for_bank_cheque = base64_decode($base64Image_for_bank_cheque);
            $decodedImage_for_id_proof = base64_decode($base64Image_for_id_proof);

            $fileName = uniqid() .'.jpeg';
            $fileNameQualification = uniqid() .'.jpeg';
            $fileNameBankCheque = uniqid() .'.jpeg';
            $fileNameIdProof = uniqid() .'.jpeg';


            file_put_contents(public_path('profile_picture/' . $fileName), $decodedImage_for_profile);
            file_put_contents(public_path('qualification/' . $fileNameQualification), $decodedImage_for_qualification);
            file_put_contents(public_path('bankcheque/' . $fileNameBankCheque), $decodedImage_for_bank_cheque);
            file_put_contents(public_path('id_proof/' . $fileNameIdProof), $decodedImage_for_id_proof);

            //$imageUrl = url('invoices/' . $fileName);

            $loggedInTrainer = auth()->user();

            //dd($loggedInTrainer->id);
            $trainer_detail =new TrainerDetail;
            // $trainer_detail->user_id =$loggedInTrainer->id;
            // $trainer_detail->preffered_language=$request->preffered_language;
            // $trainer_detail->expertise=$request->expertise;
            // $trainer_detail->qualification_name=$request->qualification_name;
            // $trainer_detail->intro=$request->intro;
            // $trainer_detail->ac_no=$request->ac_no;
            // $trainer_detail->reenter_ac_no=$request->reenter_ac_no;
            // $trainer_detail->ifsc_code=$request->ifsc_code;
            // $trainer_detail->bank_name=$request->bank_name;

            // $trainer_detail->profile_picture_file=$fileName;
            // $trainer_detail->qualification_file=$fileNameQualification;
            // $trainer_detail->bank_check_file=$fileNameBankCheque;
            // $trainer_detail->id_proof_file=$fileNameIdProof;
            // $trainer_detail->save();

            $request->profile_picture_file=$fileName;
            $request->qualification_file=$fileNameQualification;
            $request->bank_check_file=$fileNameBankCheque;
            $request->id_proof_file=$fileNameIdProof;
            
            $guidance = is_array($request->guidance) ? $request->guidance : explode(",",$request->guidance);
            $request->merge(['guidance'=>$guidance]);
            $userData =  $this->trainerService->updateOrCreateProfile($request->all(), $userId);

            $imageUrl = url('profile_picture/' . $fileName);
            $qualification_url = url('qualification/' . $fileNameQualification);
            $bank_cheque_url = url('bankcheque/' . $fileNameBankCheque);
            $id_proof_url = url('id_proof/' . $fileNameIdProof);

            //return response()->json(['id_proof_url' => $id_proof_url], 201);

               if($userData){
                   return $this->responseJson(true,200,"",['profile_picture_url' => $imageUrl, 'qualification_url' => $qualification_url, 'bank_cheque_url' => $bank_cheque_url, 'id_proof_url' => $id_proof_url,'trainer_details'=>new TrainerDetailApiCollection($userData)]);


                }




       }









}
