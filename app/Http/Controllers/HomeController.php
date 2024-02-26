<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use App\Models\UserFootitem;
use App\Models\UserHealthschedule;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {




        $rewardList = User::find($id);

        if ($rewardList) {
            // Check if the refer_code_go field is blank/null/empty before updating
            if (empty($rewardList->refer_code_go)) {
                $refercode = Str::random(8, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                $rewardList->install_count = $rewardList->install_count + 1;
                $rewardList->refer_code_go = $refercode;
                $rewardList->save();
                // Field was updated
            } else {
                $refercode =  $rewardList->refer_code_go;
            }
        } else {
            // User not found
        }

        return view('home', compact('refercode'));
    }

    public function userPlanExpires(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $user = User::where('plan_expire', $today)->get();
        foreach ($user as $users) {
            $user = User::where('id', $users->id)->first();
            $user->payment_type = 0;
            $user->is_subscribed = 0;
            $user->save();
        }
    }

    public function sendNotification(Request $request)
    {
        $user = User::where('is_subscribed', '1')->get();
        foreach ($user as $users) {
            $fooditem = UserFootitem::where('user_id', $users->id)->where('status', '0')->get();

            $headth = UserHealthschedule::where('user_id', $users->id)->first();
         if(isset($headth->sleep_schedule)){
            $time = $headth->sleep_schedule;
            $formattedTime = date("h:i A", strtotime($time));
           
             $addhours = "+" . $headth->total_sleep_hours . " hours";
             $time->modify($addhours);
             $morningtime=$time->format('h:i A');  // Output: Updated time
             echo $morningtime;
             die();
             $current_time = date('h:i A');
           if($formattedTime < $current_time){
            if ($fooditem) {
                $requestparam = (object)array(
                    'body' => 'Complete Questionnaire to get your personalised plan.',
                    'title' => 'Swasthfit'
                );
                $fcm = $users->fcm_token;
                $this->sendNotificationtest($requestparam, $fcm);
            }
        }
        }
        }
    }

    public function sendNotificationTwo(Request $request)
    {
        $user = User::where('is_subscribed', '1')->get();
        foreach ($user as $users) {
            $fooditem = UserFootitem::where('user_id', $users->id)->where('status', '1')->get();
            $headth = UserHealthschedule::where('user_id', $users->id)->first();
           
            $time = $headth->sleep_schedule;
            $formattedTime = date("h:i A", strtotime($time));
            $addhours = "+" . $headth->total_sleep_hours . " hours";
            $time->modify($addhours);
             $morningtime=$time->format('h:i A');  // Output: Updated time
             $current_time = date('h:i A');
           if($morningtime < $current_time){
            if ($fooditem) {
                $requestparam = (object)array(
                    'body' => 'Complete Questionnaire to get your personalised plan.',
                    'title' => 'Swasthfit'
                );
                $fcm = $users->fcm_token;
                $this->sendNotificationtest($requestparam, $fcm);
            }
        }
        }
    }



    public function sendNotificationtest($requestparam, $fcm)
    {
        $SERVER_API_KEY = env('FIREBASE_KEY', '');
        $data = [
            "to" => $fcm,
            "notification" => [
                "title" => $requestparam->title,
                "body" => $requestparam->body,
            ],
            'priority' => 'high'
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=AAAAu9TuhAA:APA91bEGVFgrGGht7qbu7TGSUUWilCvcqf-YDRxKXfwt3vCbqpFbGtDvQWMC41Is19XvgyZa6q5Ge0lX5AuDszqPQ2uX5JYnyyAPI_6ZEPYoxJ4WKXicvv54JJk_ZoIpSJjdF9kGF1_a',
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        if ($response === FALSE) {

            die('FCM Send Error: ' . curl_error($ch));
        }
        return $response;
        //dd($response);
    }
}
