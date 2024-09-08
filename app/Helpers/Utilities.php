<?php

use App\Models\RestaurantMedia;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


if (!function_exists('isSluggable')) {
    function isSluggable($value)
    {
        return Str::slug($value);
    }
}



if (!function_exists('isMobileDevice')) {
    function isMobileDevice()
    {
        return preg_match(
            "/(android|avantgo|blackberry|bolt|boost|cricket|docomo
                            |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i",
            $_SERVER["HTTP_USER_AGENT"]
        );
    }
}

if (!function_exists('getStatusName')) {
    function getStatusName($status)
    {
        $returnData = "In Active";
        if ($status == 1) {
            $returnData = "Active";
        } else if ($status == 3) {
            $returnData = "Deleted";
        } else if ($status == 4) {
            $returnData = "Drafted";
        }
        return $returnData;
    }
}

if (!function_exists('getCustomerCode')) {
    function getCustomerCode($id)
    {
        $returnData = $id;
        $returnData = auth()->user()->mfi->code . str_pad($id, 6, 0, STR_PAD_LEFT);
        return $returnData;
    }
}
if (!function_exists('emiFrequencyOption')) {
    function emiFrequencyOption()
    {
        $returnData = [
            ['value' => "daily", 'lable' => 'Daily'],
            ['value' => "weekly", 'lable' => 'Weekly'],
            ['value' => "biweekly", 'lable' => 'Biweekly'],
            ['value' => "monthly", 'lable' => 'Monthly']
        ];

        return $returnData;
    }
}
if (!function_exists('getGuidance')) {
    function getGuidance()
    {
        $returnData = [
            ['value' => "diet_plan", 'lable' => 'Diet Plan'],
            ['value' => "home_workout", 'lable' => 'Home Workout'],
            ['value' => "coach_guidance", 'lable' => 'Coach Guidance'],
            ['value' => "muscle_gain", 'lable' => 'Muscle Gain'],
            ['value' => "weight_gain", 'lable' => 'Weight Gain'],
            ['value' => "weight_loss", 'lable' => 'Weight Loss']
        ];

        return $returnData;
    }
}

if (!function_exists('getBank')) {
    function getBank()
    {
        $returnData = [
            ['value' => "ICICI Bank", 'lable' => 'ICICI Bank'],
            ['value' => "State Bank of India", 'lable' => 'State Bank of India'],
            ['value' => "Bank of Baroda", 'lable' => 'Bank of Baroda'],
            ['value' => "Canara Bank", 'lable' => 'Canara Bank'],
            ['value' => "PNB", 'lable' => 'PNB'],
            ['value' => "Bank Of India", 'lable' => 'Bank Of India'],
            ['value' => "Punjab National Bank", 'lable' => 'Punjab National Bank'],
            ['value' => "Indian Bank", 'lable' => 'Indian Bank'],
            ['value' => "Axis Bank", 'lable' => 'Axis Bank'],
            ['value' => "Indian Overseas Bank", 'lable' => 'Indian Overseas Bank'],
            ['value' => "HDFC Bank", 'lable' => 'HDFC Bank'],
            ['value' => "Axis Bank Ltd", 'lable' => 'Axis Bank Ltd'],
            ['value' => "UCO Bank", 'lable' => 'UCO Bank'],
            ['value' => "Union Bank of India", 'lable' => 'Union Bank of India'],
            ['value' => "Central Bank of India", 'lable' => 'Central Bank of India'],
            ['value' => "IDBI Bank", 'lable' => 'IDBI Bank'],
            ['value' => "HDFC Bank Ltd", 'lable' => 'HDFC Bank Ltd'],
            ['value' => "IndusInd Bank", 'lable' => 'IndusInd Bank'],
            ['value' => "Bank of Maharashtra", 'lable' => 'Bank of Maharashtra'],
            ['value' => "Federal Bank", 'lable' => 'Federal Bank'],
            ['value' => "Kotak Mahindra Bank Ltd", 'lable' => 'Kotak Mahindra Bank Ltd'],
            ['value' => "IDBI Bank Ltd", 'lable' => 'IDBI Bank Ltd'],
            ['value' => "Allahabad Bank", 'lable' => 'Allahabad Bank']
        ];

        return $returnData;
    }
}

if (!function_exists('getDocumentsUrl')) {
    function getDocumentsUrl($documents)
    {
        $documentUrl = [];
        foreach ($documents as $key => $value) {
            if (!empty($value)) {
                $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
                $docPath = config('constants.SITE_KYC_DOCUMENT_UPLOAD_PATH');
                if ($fileDisk == 'public') {
                    if (file_exists(public_path('storage/' . $docPath . $value->file))) {
                        $documentUrl[] = asset('storage/' . $docPath .  $value->file);
                    } else {
                        $documentUrl[] = asset('assets/images/pro_img.jpg');
                    }
                }
            }
        }
        return $documentUrl;
    }
}

if (!function_exists('stringToHuman')) {
    function stringToHuman($slug)
    {
        $returnData = Str::title(str_replace('_', ' ', $slug));
        return $returnData;
    }
}

if (!function_exists('genrateOtp')) {
    function genrateOtp($digit = 6)
    {

        // Take a generator string which consist of
        // all numeric digits
        $generator = "1357902468";

        // Iterate for n-times and pick a single character
        // from generator and append it to $result

        // Login for generating a random character from generator
        //     ---generate a random number
        //     ---take modulus of same with length of generator (say i)
        //     ---append the character at place (i) from generator to result

        $result = "";
        for ($i = 1; $i <= $digit; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }
}
if (!function_exists('propertyTypeOption')) {
    function propertyTypeOption()
    {
        $returnData = [
            ['value' => "public", 'lable' => 'Public'],
            ['value' => "private", 'lable' => 'Private']
        ];

        return $returnData;
    }
}
if (!function_exists('propertyConditionOption')) {
    function propertyConditionOption()
    {
        $returnData = [
            ['value' => "own", 'lable' => 'Own'],
            ['value' => "rented", 'lable' => 'Rented']
        ];

        return $returnData;
    }
}

if (!function_exists('relationOption')) {
    function relationOption()
    {
        $returnData = [
            ['value' => "father", 'lable' => 'Father'],
            ['value' => "mother", 'lable' => 'Mother'],
            ['value' => "brother", 'lable' => 'Brother'],
            ['value' => "sister", 'lable' => 'Sister'],
            ['value' => "father_in_law", 'lable' => 'Father In Law'],
            ['value' => "mother_in_law", 'lable' => 'Mother In Law'],
            ['value' => "sister_in_law", 'lable' => 'Sister In Law'],
            ['value' => "brother_in_law", 'lable' => 'Brother In Law']
        ];

        return $returnData;
    }
}
if (!function_exists('titleOption')) {
    function titleOption()
    {
        $returnData = [
            ['value' => "mr", 'lable' => 'Mr'],
            ['value' => "mrs", 'lable' => 'Mrs']
        ];

        return $returnData;
    }
}
if (!function_exists('sidebar_open')) {
    function sidebar_open($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

        return $open ? 'active' : '';
    }
}
if (!function_exists('slide_down')) {
    function slide_down($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

        return $open ? 'menu-open' : '';
    }
}
if (!function_exists('arrow_down')) {
    function arrow_down($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

        return $open ? 'rotate-180' : 'rotate-0';
    }
}
if (!function_exists('getBranchId')) {
    function getBranchId()
    {
        $branch_id = auth()->user()->branch->branch_id;
        return $branch_id;
    }
}
if (!function_exists('getBranchUUID')) {
    function getBranchUUID()
    {
        $branchUUId = auth()->user()->branches[0]->uuid;
        return $branchUUId;
    }
}
if (!function_exists('checkIsHeadBranch')) {
    function checkIsHeadBranch()
    {
        $is_head_branch = false;
        $branches = auth()->user()->branches;
        if (!empty($branches) && count($branches)) {
            $collection = collect($branches);
            $is_head_branch = $collection->where('is_head_branch', 1)->first();
            if (!empty($is_head_branch)) {
                $is_head_branch = true;
            } else {
                $is_head_branch = false;
            }
        }
        return $is_head_branch;
    }
}


if (!function_exists('getAllBranchIds')) {
    function getAllBranchIds()
    {
        $branch_ids = [];
        $branches = auth()->user()->branches;
        if (!empty($branches) && count($branches)) {
            $collection = collect($branches);
            $is_head_branch = $collection->where('is_head_branch', 1)->first();
            if (!empty($is_head_branch)) {
                $branch_ids = array_column((auth()->user()->mfi->branches->toArray()), 'id');
            } else {
                $branch_ids = array_column(($branches->toArray()), 'id');
            }
        }
        return $branch_ids;
    }
}
if (!function_exists('getBranchIdByCitiPincode')) {
    function getBranchIdByCitiPincode($cityName = "", $zipCode = "")
    {
        $branch_id = auth()->user()->branch->branch_id;
        $branches = auth()->user()->branches;
        // return $branches;
        if (!empty($branches) && count($branches) && (!empty($cityName) || !empty($zipCode))) {
            foreach ($branches as $key => $branch) {
                if ($branch->oprationArea) {
                    $zipCodes = json_decode($branch->oprationArea->zip_codes, true);
                    $citiesName = json_decode($branch->oprationArea->cities_name, true);
                    if (in_array($zipCode, $zipCodes)) {
                        $branch_id = $branch->id;
                    } else if (in_array($cityName, $citiesName)) {
                        $branch_id = $branch->id;
                    }
                }
            }
        }
        return $branch_id;
    }
}
if (!function_exists('sidebar_inner_open')) {
    function sidebar_inner_open($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

        return $open ? 'text-indigo-500' : 'text-slate-400';
    }
}

if (!function_exists('sidebar_menu_open')) {
    function sidebar_menu_open($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

        return $open ? 'bg-slate-900' : '';
    }
}

if (!function_exists('auth_sidebar')) {
    function auth_sidebar($routes = [])
    {
        $currRoute = Route::currentRouteName();
        $open = false;
        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                if (str_contains($currRoute, substr($route, 0, strpos($route, '*')))) {
                    $open = true;
                    break;
                }
            } else {
                if ($currRoute === $route) {
                    $open = true;
                    break;
                }
            }
        }

        return $open ? 'active' : '';
    }
}

if (!function_exists('getS3URL')) {
    function getS3URL($filePath, $fileType = '', $fileAccessMode = 'private')
    {
        $storageDisk = Storage::disk('s3');

        if ($storageDisk->exists($filePath)) {
            if ($fileAccessMode == 'public') {
                $url = $storageDisk->url($filePath);
            } else if ($fileAccessMode == 'private') {
                $url = $storageDisk->temporaryUrl(
                    $filePath,
                    now()->addMinutes(10080)
                );
            }

            return $url;
        } else {
            if ($fileType == 'profilePicture') {
                return asset('assets/frontend/images/no-profile-picture.jpeg');
            } else if ($fileType == 'postImage') {
                //return 'https://dummyimage.com/540x400/ffffff/2a3680.png&text=Unable+to+load+this+file';
                return asset('assets/frontend/images/no-image-medium.png');
            } else if ($fileType == 'collectionImage') {
                //return 'https://dummyimage.com/150x150/ffffff/2a3680.png&text=Unable+to+load+this+file';
                return asset('assets/frontend/images/no-image-small.png');
            } else if ($fileType == 'profilePhotoId') {
                return asset('assets/frontend/images/file-not-found.png');
            } else if ($fileType == 'cityImage') {
                return asset('assets/frontend/images/location-placeholder.jpeg');
            } else {
                return false;
            }
        }
    }
}

if (!function_exists('imageResizeAndSave')) {
    function imageResizeAndSave($imageUrl, $type = 'post/image', $filename = null)
    {
        if (!empty($imageUrl)) {


            Storage::disk('public')->makeDirectory($type . '/60x60');
            $path60X60     = storage_path('app/public/' . $type . '/60x60/' . $filename);
            $image = Image::make($imageUrl)->resize(
                null,
                60,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            //$canvas->insert($image, 'center');
            $image->save($path60X60, 70);

            //save 350X350 image
            Storage::disk('public')->makeDirectory($type . '/350x350');
            $path350X350     = storage_path('app/public/' . $type . '/350x350/' . $filename);
            $image = Image::make($imageUrl)->resize(
                null,
                350,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );

            $image->save($path350X350, 75);

            return $filename;
        } else {
            return false;
        }
    }
}

if (!function_exists('siteSetting')) {
    function siteSetting($key = '')
    {
        return \App\Models\Setting::where('key', $key)->value('value');
    }
}

if (!function_exists('uuidtoid')) {
    function uuidtoid($uuid, $table)
    {
        $dbDetails = DB::table($table)
            ->select('id')
            ->where('uuid', $uuid)->first();

        if ($dbDetails) {
            return $dbDetails->id;
        } else {
            abort(404);
        }
    }
}

if (!function_exists('customfind')) {
    function customfind($id, $table)
    {
        $dbDetails = DB::table($table)
            ->find($id);
        if ($dbDetails) {
            return $dbDetails;
        } else {
            abort(404);
        }
    }
}

if (!function_exists('safe_b64encode')) {
    function safe_b64encode($string)
    {
        $pretoken = "";
        $posttoken = "";

        $codealphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codealphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codealphabet .= "0123456789";
        $max = strlen($codealphabet); // edited

        for ($i = 0; $i < 3; $i++) {
            $pretoken .= $codealphabet[rand(0, $max - 1)];
        }

        for ($i = 0; $i < 3; $i++) {
            $posttoken .= $codealphabet[rand(0, $max - 1)];
        }

        $string = $pretoken . $string . $posttoken;
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }
}

if (!function_exists('safe_b64decode')) {
    function safe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }

        $data = base64_decode($data);
        $data = substr($data, 3);
        $data = substr($data, 0, -3);

        return $data;
    }
}

if (!function_exists('customEcho')) {
    function customEcho($str, $length)
    {
        if (strlen($str) <= $length) return $str;
        else return substr($str, 0, $length) . '...';
    }
}

if (!function_exists('trasactionPriceBreakUp')) {
    function trasactionPriceBreakUp($purchaseItemPrice)
    {
        $purchaseItemVatPrice = 0;

        $purchaseItemVatPrice = 0;


        $purchaseItemTotalPrice = ($purchaseItemPrice + $purchaseItemVatPrice);

        return [
            'purchaseItemPrice'      => $purchaseItemPrice,
            'purchaseItemVatPrice'   => $purchaseItemVatPrice,
            'purchaseItemTotalPrice' => $purchaseItemTotalPrice
        ];
    }
}

if (!function_exists('formatTime')) {
    function formatTime($time)
    {
        return Carbon::parse($time)->format('dS M, Y, \\a\\t\\ g:i A');
    }
}
if (!function_exists('currentDate')) {
    function currentDate()
    {
        return Carbon::now()->format('Y-m-d H:i:s');
    }
}


if (!function_exists('getSiteSetting')) {
    function getSiteSetting($key)
    {
        return \App\Models\Setting::where('key', $key)->value('value');
    }
}

if (!function_exists('mime_check')) {
    function mime_check($path)
    {
        if ($path) {
            $typeArray = explode('.', $path);
            $fileType = strtolower($typeArray[count($typeArray) - 1]) ?? 'jpg';
            if ($fileType == 'png') {
                return 'image/png';
            } elseif ($fileType == 'jpg' || $fileType == 'jpeg') {
                return 'image/jpg';
            } elseif ($fileType == 'webp') {
                return 'image/webp';
            } elseif ($fileType == 'mp4') {
                return 'video/mp4';
            } elseif ($fileType == 'webm') {
                return 'video/webm';
            }
        }
        return 'image/*';
    }
}


function uploadMedia($request, $mediaable, $mediaableType, $fileInputName = 'image', $mediaType = 'image', $directory = 'uploads', $validationRules = [])
{
    // Check if the request has the specified file
    if ($request->hasFile($fileInputName)) {
        // Default validation rules for images if not provided
        $defaultValidationRules = [
            $fileInputName => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Use custom or default validation rules
        $request->validate($validationRules ?: $defaultValidationRules);

        // Get the file and generate a unique name
        $file = $request->file($fileInputName);
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        // Move the file to the specified directory
        $file->move(public_path($directory), $fileName);

        // Create and save the media record
        $media = new \App\Models\RestaurantMedia();
        $media->uuid = Str::uuid();
        $media->user_id = Auth::user()->id;
        $media->restaurant_id = Auth::user()->restaurant->id;  // Adjust as necessary for other use cases
        $media->mediaable_id = $mediaable->id;
        $media->mediaable_type = $mediaableType;
        $media->media_type = $mediaType;
        $media->file = $fileName;
        $media->save();

        return $media;  // Return the saved media model
    }
}
