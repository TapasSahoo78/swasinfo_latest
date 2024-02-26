<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\AddCustomerRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUsers;
use App\Models\ApiHit;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Response;

use App\Models\Log;

class SalesAgentController extends BaseController
{

    protected $roleService;

    protected $userService;

    public function __construct(
        UserService $userService,
        RoleService $roleService
    ) {
        $this->userService    = $userService;
        $this->roleService    = $roleService;
    }
    public function index(Request $request)
    {
        $this->setPageTitle('All Agent Manager');
        $filterConditions = [];
        $userId = auth()->user()->id;
        if ($userId == 1) {
            $users = $this->userService->getCustomers('sales-agent', $filterConditions);
        } else {
            $users = $this->userService->getCustomersales('sales-agent', $filterConditions);
        }
        //dd($users);
        return view('admin.agent.index', compact('users'));
    }
    public function addAgent(Request $request)
    {
        $this->setPageTitle('Add Agent');
        if ($request->post()) {
            //dd($request->all());
            $request->validate([
                'name'     =>  'required|string',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'mobile_number' => 'required|numeric|unique:users,mobile_number,NULL,id,deleted_at,NULL|regex:/^[0-9]{10}$/',
                'password'       => 'required|string'
            ]);
            DB::beginTransaction();
            try {
                $isFaqCreated = $this->userService->createOrUpdateAgent($request->except('_token'));
                if ($isFaqCreated) {
                    DB::commit();
                    return $this->responseRedirect('admin.agent.list', 'Sales Manager created successfully', 'success', false);
                }
            } catch (\Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return $this->responseRedirectBack('Something went wrong', 'error', true);
            }
        }
        return view('admin.agent.trainer-add');
    }


    public function store(AddCustomerRequest $request)
    {

        DB::beginTransaction();
        try {
            $request->merge(['registration_ip' => $request->ip()]);
            $isCustomerCreated = $this->userService->createOrUpdateCustomer($request->except('_token'));
            if ($isCustomerCreated) {
                DB::commit();
                return $this->responseRedirect('admin.agent.list', 'Customer created Successfully', 'success', false, false);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseRedirectBack('Something went wrong', 'error', true);
        }
    }


    public function editAgent(Request $request, $uuid)
    {
      
        $this->setPageTitle('Edit Agent');
        $id = uuidtoid($uuid, 'users');
      
        $user = $this->userService->findUser($id);
        if ($request->post()) {
            $this->validate($request, [
                'name'     =>  'required|string',
                'mobile_number' => [
                    'required',
                    'numeric',
                    'regex:/^[0-9]{10}$/',
                    'unique:users,mobile_number,' . $id . ',id,deleted_at,NULL',
                ],
            ]);
            DB::beginTransaction();
            //try {
              $isCustomerUpdated = $this->userService->createOrUpdateDoctor($request->except(['_token', 'email']), $id);
            if ($isCustomerUpdated) {
                DB::commit();
                return $this->responseRedirect('admin.agent.list', 'Sales Manager updated successfully', 'success', false);
            }
            //} catch (\Exception $e) {
            //DB::rollback();
            //logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            //return $this->responseRedirectBack('Something went wrong', 'error', true);
            //}
        }
        return view('admin.agent.trainer-edit', compact('user'));
    }


    public function import()
    {
        try {
            $file = request()->file('file');
        
            if ($file !== null && $file->getSize() > 0 && $file->isValid()) {
              
                $importUsers = new ImportUsers();
                Excel::import($importUsers, $file);
            } else {
                throw new \Exception('The uploaded file is empty, invalid, or not a valid file format.');
            }
        } catch (\Throwable $th) {
            return back()->with('errorr', $th->getMessage());
        }

        return back()->with('successs', 'CSV file imported successfully!');
    }

    public function reportAgent(Request $request, $uuid)
    {
     
        $this->setPageTitle('Report');
         $id = uuidtoid($uuid, 'users');
        $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();
        $userId = auth()->id();
        $users=User::where('id',$id)->first();
        
    
      


        $recentApiHits = ApiHit::select('request_page', 'ip_address', 'created_at')
            ->where('user_id', $id)
            ->where('created_at', '>=', $lastWeek)
            ->get();

        $recentlogcount = Log::select('time_spend','created_at')
            ->where('user_id', $id)
            ->where('created_at', '>=', $lastWeek)
            ->get();
        
        $time=[];
        foreach($recentlogcount as $count){
            $time[]=$count->time_spend;
        }
        $totalTime = array_sum($time);
        $hours = floor($totalTime / 3600);

        // Calculate remaining seconds after extracting hours
        $remainingSeconds = $totalTime % 3600;
        
        // Calculate minutes
        $minutes = floor($remainingSeconds / 60);
        
        // Calculate remaining seconds after extracting minutes
        $remainingSeconds = $remainingSeconds % 60;
        
        // Output the result
        $apptime= "$hours hours, $minutes minutes, $remainingSeconds seconds";
     
    // Calculate remaining minute    
        if($users->refer_code_go){ 
            $vistcount = User::where('refer_code_come', $users->refer_code_go)->count();
            $subscriptioncount = User::where('refer_code_come', $users->refer_code_go)->where('is_subscribed','1')->count();
        }else{
            $vistcount = 0;
            $subscriptioncount = 0;
        }
        $filterConditions = [];
        
        
        return view('admin.agent.report',compact('recentApiHits','vistcount','users','subscriptioncount','id','apptime','users'));
    }



    public function reportTotalAgent(Request $request, $uuid)
    {
        $this->setPageTitle('Report');
        $id = uuidtoid($uuid, 'users');
        $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();
        $userId = auth()->id();
        $users=User::where('id',$id)->first();
        $userss = User::where('created_by',$id)->pluck('id');
        $userss[] = $id;
    
        $recentApiHits = ApiHit::select('request_page', 'ip_address', 'created_at')  // Selecting specific columns
        ->whereIn('user_id', $userss)  // Filtering by user_id being in the $id array
        ->where('created_at', '>=', $lastWeek)  // Filtering by created_at being greater than or equal to $lastWeek
        ->get();  // Executing the query and retrieving the results

        $recentlogcount = Log::select('time_spend','created_at')
        ->whereIn('user_id', $userss)
            ->where('created_at', '>=', $lastWeek)
            ->get();
       $time=[];
        foreach($recentlogcount as $count){
            $time[]=$count->time_spend;
        }
        $totalTime = array_sum($time);
        $hours = floor($totalTime / 3600);

        // Calculate remaining seconds after extracting hours
        $remainingSeconds = $totalTime % 3600;
        
        // Calculate minutes
        $minutes = floor($remainingSeconds / 60);
        
        // Calculate remaining seconds after extracting minutes
        $remainingSeconds = $remainingSeconds % 60;
        
        // Output the result
        $apptime= "$hours hours, $minutes minutes, $remainingSeconds seconds";
     
        $userssapi = User::where('created_by',$id)->get();
        $vistcounts=[];
        $subscriptioncounts=[];
        foreach($userssapi as $datas){
            $vistcounts[] = User::where('refer_code_come', $datas->refer_code_go)->count();
            $subscriptioncounts[] = User::where('refer_code_come', $datas->refer_code_go)->where('is_subscribed','1')->count();

        }
  
        $vistcount = array_sum($vistcounts);
        $subscriptioncount = array_sum($subscriptioncounts);
   
    // Calculate remaining minute    
        // if($users->refer_code_go){ 
        //     $vistcount = User::where('refer_code_come', $users->refer_code_go)->count();
        //     $subscriptioncount = User::where('refer_code_come', $users->refer_code_go)->where('is_subscribed','1')->count();
        // }else{
        //     $vistcount = 0;
        //     $subscriptioncount = 0;
        // }
        
        
        return view('admin.agent.report',compact('recentApiHits','vistcount','users','subscriptioncount','id','apptime','users'));
    }

    public function reportExportCsv(Request $request, $uuid)
    {
       
        $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();
        $userId = auth()->id();
        $users=User::where('id',$uuid)->first();
        $userss = User::where('created_by',$uuid)->pluck('id');
        $userss[] = $uuid;
    
        $recentApiHits = ApiHit::select('request_page', 'ip_address', 'created_at')  // Selecting specific columns
        ->whereIn('user_id', $userss)  // Filtering by user_id being in the $id array
        ->where('created_at', '>=', $lastWeek)  // Filtering by created_at being greater than or equal to $lastWeek
        ->get();  // Executing the query and retrieving the results
        $lastWeek = Carbon::now()->subDays(7)->toDateTimeString();
        $users=User::where('id',$uuid)->first();
        $recentlogcount = Log::select('time_spend','created_at')
            ->where('user_id', $uuid)
            ->where('created_at', '>=', $lastWeek)
            ->get();
        
        $time=[];
        foreach($recentlogcount as $count){
            $time[]=$count->time_spend;
        }
        $totalTime = array_sum($time);
        $hours = floor($totalTime / 3600);

        // Calculate remaining seconds after extracting hours
        $remainingSeconds = $totalTime % 3600;
        
        // Calculate minutes
        $minutes = floor($remainingSeconds / 60);
        
        // Calculate remaining seconds after extracting minutes
        $remainingSeconds = $remainingSeconds % 60;
        
        // Output the result
        $apptime= "$hours hours, $minutes minutes, $remainingSeconds seconds"; // Convert to hours
        if($users->refer_code_go){
            $vistcount = User::where('refer_code_come', $users->refer_code_go)->count();
            $subscriptioncount = User::where('refer_code_come', $users->refer_code_go)->where('is_subscribed','1')->count();
        }else{
            $vistcount = 0;
            $subscriptioncount = 0;
        }
        $uninstalled=0;
    
        // $data = [
        //     ['No. Of Installing', 'Total Time Spend in the App', 'No. Of Visits in the app', 'Subscription Purchases Count','No. Of Uninstalling'],
        //     [
        //         $vistcount, // Replace with actual data for 'No. Of installing'
        //         $apptime, // Replace with actual data for 'Subscription purchases'
        //         $vistcount, // Replace with actual data for 'No. Of Visits in the app'
        //         $subscriptioncount,
        //         $uninstalled, // Replace with actual data for 'Subscription purchases Count'
        //     ],
        // ];
        
        // $csv = Writer::createFromString('');
        // $csv->insertAll($data);
       
        // $fileName = 'Report.csv';
 
        // return response($csv->output(), 200, [
        //     'Content-Type' => 'text/csv',
        //     'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        // ]);


        // $csvData = [
        //     ['No. Of installing', $vistcount],
        //     ['Total Time Spend in the App', $apptime],
        //     ['No. Of Visits in the app', $vistcount],
        //     ['Subscription purchases Count', $subscriptioncount],
        //     ['No. Of Uninstalling', $uninstalled],
        // ];

        $csvData = [
            ['Page Name', 'IP Address', 'Date', 'No. Of installing', 'Total Time Spend in the App', 'No. Of Visits in the app', 'Subscription purchases Count', 'No. Of Uninstalling']
        ];
        
        foreach ($recentApiHits as $data) {
            $csvData[] = [
                $data->request_page,
                $data->ip_address,
                date('d-m-Y', strtotime($data->created_at)),
                '10',
                '5',
                '12',
                '10',
                '4'
            ];
        }

        // Generate CSV file
        $fileName = 'exported_data_' . date('Y-m-d') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function qrPage(Request $request, $uuid){
        return view('admin.agent.qrpage',compact('uuid'));
    }

}
