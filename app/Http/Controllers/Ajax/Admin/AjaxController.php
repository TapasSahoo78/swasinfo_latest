<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\Faq\FaqService;
use App\Services\Mfi\MfiService;
use App\Services\Blog\BlogService;
use App\Services\Lead\LeadService;
use App\Services\Loan\LoanService;
use App\Services\Menu\MenuService;
use App\Services\Page\PageService;
use App\Services\Role\RoleService;
use App\Services\User\UserService;
use App\Services\Brand\BrandService;
use App\Services\Store\StoreService;
use App\Services\Banner\BannerService;
use App\Services\Branch\BranchService;
use App\Services\Coupon\CouponService;
use App\Http\Controllers\BaseController;
use App\Services\Account\AccountService;
use App\Services\Enquiry\EnquiryService;
use App\Services\Product\ProductService;
use App\Services\Purpose\PurposeService;
use App\Services\Group\AgentGroupService;
use App\Services\Category\CategoryService;
use App\Http\Resources\Admin\Mfi\MfiResource;
use App\Http\Resources\Mfi\Lead\LeadResource;
use App\Http\Resources\Mfi\Loan\LoanResource;
use App\Http\Resources\Mfi\Role\RoleResource;
use App\Http\Resources\Mfi\User\UserResource;
use App\Services\Occupation\OccupationService;
use App\Http\Resources\Mfi\Group\GroupResource;
use App\Http\Resources\Mfi\Notes\NotesResource;
use App\Services\Testimonial\TestimonialService;
use App\Http\Resources\Mfi\Branch\BranchResource;
use App\Http\Resources\Mfi\Demand\DemandResource;
use App\Http\Resources\Mfi\Account\AccountResource;
use App\Http\Resources\Mfi\Enquiry\EnquiryResource;
use App\Http\Resources\Mfi\Lead\LeadVerifyResource;
use App\Http\Resources\Mfi\LoanEmi\LoanEmiResource;
use App\Http\Resources\Mfi\Purpose\PurposenResource;
use App\Http\Resources\Mfi\Customer\CustomerResource;
use App\Http\Resources\Mfi\Lead\CustomerLeadResource;
use App\Http\Resources\Mfi\Demand\DemandNotesResource;
use App\Http\Resources\Mfi\Customer\CustomerKycResource;
use App\Http\Resources\Mfi\Demand\DemandCustomerResource;
use App\Http\Resources\Mfi\Occupation\OccupationResource;
use App\Http\Resources\Mfi\Branch\BranchOprationAreaResource;
use App\Models\LiveSession;
use App\Models\Product;
use App\Models\RestaurantsSubCategorie;

class AjaxController extends BaseController
{
    /**
     * @var CouponService
     */
    protected $couponService;
    /**
     * @var ProductService
     */
    protected $productService;
    /**
     * @var MenuService
     */
    protected $menuService;
    /**

     * @var UserService
     */
    protected $userService;
    /**
     * @var BannerService
     */
    protected $bannerService;
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * @var RoleService
     */
    protected $roleService;
    /**
     * @var PageService
     */
    protected $pageService;

    /**
     * @var BrandService
     */
    protected $brandService;

    /**
     * @var BlogService
     */
    protected $blogService;

    /**
     * @var FaqService
     */
    protected $faqService;
    /**
     * @var TestimonialService
     */
    protected $testimonialService;
    /**
     * @var MfiService
     */
    protected $mfiService;
    /**
     * @var StoreService
     */
    protected $storeService;

    /**
     * @var BranchService
     */
    protected $branchService;
    /**
     * @var LoanService
     */
    protected $loanService;
    /**
     * @var PurposeService
     */
    protected $purposeService;
    /**
     * @var OccupationService
     */
    protected $occupationService;
    /**
     * @var AccountService
     */
    protected $accountService;
    /**
     * @var LeadService
     */
    protected $leadService;
    /**
     * @var EnquiryService
     */
    protected $enquiryService;
    /**
     * @var AgentGroupService
     */
    protected $agentGroupService;

    public function __construct(
        RoleService $roleService,
        UserService $userService,
        PageService $pageService,
        CategoryService $categoryService,
        MenuService $menuService,
        ProductService $productService,
        BannerService $bannerService,
        CouponService $couponService,
        BrandService $brandService,
        BlogService $blogService,
        FaqService $faqService,
        TestimonialService $testimonialService,
        StoreService $storeService,
        MfiService $mfiService,
        BranchService $branchService,
        LoanService $loanService,
        PurposeService $purposeService,
        OccupationService $occupationService,
        AccountService $accountService,
        LeadService $leadService,
        EnquiryService $enquiryService,
        AgentGroupService $agentGroupService
    ) {
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->pageService = $pageService;
        $this->bannerService = $bannerService;
        $this->userService = $userService;
        $this->menuService = $menuService;
        $this->productService = $productService;
        $this->couponService = $couponService;
        $this->brandService = $brandService;
        $this->blogService = $blogService;
        $this->faqService = $faqService;
        $this->testimonialService = $testimonialService;
        $this->storeService = $storeService;
        $this->mfiService = $mfiService;
        $this->branchService = $branchService;
        $this->loanService = $loanService;
        $this->purposeService = $purposeService;
        $this->occupationService = $occupationService;
        $this->accountService = $accountService;
        $this->leadService = $leadService;
        $this->enquiryService = $enquiryService;
        $this->agentGroupService = $agentGroupService;
    }

    /* public function getRoles(Request $request)
    {
    $slug = auth()->user()->mfi->code;

    $totalData = $this->roleService->getTotalData();
    $totalFiltered = $totalData;
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = 'name';
    $dir = 'asc';
    $index = $start;
    $nestedData = [];
    $data = [];
    if (empty($request->input('search.value'))) {
    $roles = $this->roleService->getList($start, $limit, $order, $dir);
    } else {
    $search = $request->input('search.value');
    $roles = $this->roleService->getList($start, $limit, $order, $dir, $search);
    $totalFiltered = $this->roleService->getTotalData($search);
    }

    $data = array();
    if (!empty($roles)) {
    foreach ($roles as $role) {
    $index++;
    $nestedData['sr'] = $index;
    $nestedData['id'] = $role->id;
    $nestedData['name'] = $role->name;
    $nestedData['description'] = $role->description;
    $statusDisplay = '<a href="javascript:void(0)" data-value="0" data-table="roles"
    data-message="inactive" data-uuid="' . $role->uuid . '"
    class="badge badge-success text-dark changeStatus">Active</a>';
    switch ($role->status) {

    case (1):
    $statusDisplay = '<a href="javascript:void(0)" data-value="0" data-table="roles"
    data-message="inactive" data-uuid="' . $role->uuid . '"
    class="badge badge-success text-dark changeStatus">Active</a>';
    break;

    case (0):
    $statusDisplay = '<a href="javascript:void(0)" data-value="1" data-uuid="' . $role->uuid . '"
    data-table="roles" data-message="active"
    class="badge badge-danger text-dark changeStatus">Inactive</a>';
    break;

    default:
    $statusDisplay = '<a href="javascript:void(0)"
    class="badge badge-danger text-dark">Deleted</a>';

    }
    $nestedData['status_display'] = $statusDisplay;

    $nestedData['created_at'] = date("d-m-Y", strtotime($role->created_at));
    $nestedData['action'] = '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    $nestedData['action'] .= '<img src="' . asset('assets/img/three-dot-btn.png') . '" alt=""></button>';
    $nestedData['action'] .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
    $nestedData['action'] .= '<a  class="dropdown-item editData" data-uuid="' . $role->uuid . '" data-message="role fetched successfully" data-table="roles" href="javascript:void(0)" data-form-modal="slide-from-right">Edit</a>';
    $nestedData['action'] .= '<a  class="dropdown-item deleteData" data-uuid="' . $role->uuid . '" data-message="role deleted successfully" data-table="roles" href="javascript:void(0)">Delete</a>';
    $nestedData['action'] .= '<a class="dropdown-item edit-permissions" href="' . route('mfi.administrator.role.attach.permission', ['slug' => $slug, 'id' => $role->id]) . '">Permissions</a>';
    $nestedData['action'] .= '</div></div>';
    $data[] = $nestedData;
    $nestedData = [];
    }
    }

    $jsonData = array(
    "draw" => (int) $request->input('draw'),
    "recordsTotal" => (int) $totalData,
    "recordsFiltered" => (int) $totalFiltered,
    "data" => $data,
    );

    return response()->json($jsonData);

    } */
    public function editCustomer(Request $request)
    {
        if ($request->ajax()) {

            $id = uuidtoid($request->uuid, "users");
            $allData = $this->userService->findUser($id);
            $data = new CustomerResource($allData);
            // $data = [
            //     'addressHtml' => view('customer.address.components.addreess')->with(['addresses' => $addressData])->render(),
            // ];
            $message = 'Customer Fetched';
            if ($data) {
                return $this->responseJson(true, 200, $message, $data);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        } else {
            abort(403);
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->name;
        $data = User::listUser('customer')->where(function ($query) use ($search) {
            $query->where('first_name', 'LIKE', '%' . $search . '%')->orWhere('mobile_number', 'LIKE', '%' . $search . '%');
        })
            ->get();
        // $data = ["Saab", "Volvo", "BMW"];
        // echo json_encode($data);
        return response()->json(DemandCustomerResource::collection($data));
    }

    public function customerAllData(Request $request)
    {
        if ($request->ajax()) {
            $filterOccupationConditions = [
                'mfi_id' => auth()->user()->mfi_id,
                'status' => 1,
            ];
            $filterLoanConditions = [
                'mfi_id' => auth()->user()->mfi_id,
                'status' => 1,
            ];

            $filterPurposeConditions = [
                'mfi_id' => auth()->user()->mfi_id,
            ];
            $listLoans = $this->loanService->listLoan($filterLoanConditions, 'id', 'asc');
            $listOccupation = $this->occupationService->listOccupation($filterOccupationConditions, 'id', 'asc');
            $listPurpose = $this->purposeService->listPurpose($filterPurposeConditions, 'id', 'asc');
            $data['list_loans'] = $listLoans;
            $data['list_occupation'] = $listOccupation;
            $data['list_purpose'] = $listPurpose;
            $message = 'Customer Fetched';
            if ($data) {
                return $this->responseJson(true, 200, $message, $data);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        } else {
            abort(403);
        }
    }
    public function getmfis(Request $request)
    {
        // try{

        $totalData = $this->mfiService->getTotalData();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = 'name';
        $dir = 'asc';
        $index = $start;
        $nestedData = [];
        $data = [];
        if (empty($request->input('search.value'))) {
            $mfis = $this->mfiService->getList($start, $limit, $order, $dir);
        } else {
            $search = $request->input('search.value');
            $mfis = $this->mfiService->getList($start, $limit, $order, $dir, $search);
            $totalFiltered = $this->mfiService->getTotalData($search);
        }

        $data = array();
        if (!empty($mfis)) {
            foreach ($mfis as $mfi) {
                $index++;
                $nestedData['sr'] = $index;
                $nestedData['id'] = $mfi->id;
                $nestedData['mfi_name'] = $mfi->name;
                $nestedData['mfi_code'] = $mfi->code;
                $nestedData['login_id'] = $mfi->user->login_id;
                $nestedData['registration_number'] = $mfi->registration_number;
                $nestedData['status'] = $mfi->status;
                $statusDisplay = "Active";
                if (!$mfi->status) {
                    $statusDisplay = "Inactive";
                }
                $nestedData['status_display'] = $statusDisplay;
                // $nestedData['slug'] = $mfi->slug;
                // $nestedData['short_code'] = $mfi->short_code;
                // $nestedData['role_type'] = $mfi->role_type;
                $nestedData['created_at'] = date("d-m-Y", strtotime($mfi->created_at));
                $nestedData['link'] = strtolower(url($mfi->code . '/login'));
                $nestedData['logo'] = '<img  class="logo_image" src = "' . $mfi->logo_picture . '" alt="image">';
                $nestedData['action'] = '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $nestedData['action'] .= '<img src="' . asset('assets/img/three-dot-btn.png') . '" alt=""></button>';
                $nestedData['action'] .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $nestedData['action'] .= '<a class="dropdown-item edit-mfi" data-uuid="' . $mfi->uuid . '" data-message="role edited successfully" data-table="mfis"  href="javascript:void">Edit</a>';
                // $nestedData['action'] .= '<a class="dropdown-item view-mfi" href="javascript:void()">view</a>';
                $nestedData['action'] .= '  <a  class="dropdown-item deleteData" data-uuid="' . $mfi->uuid . '" data-message="role deleted successfully" data-table="mfis" href="javascript:void">Delete</a >';
                $nestedData['action'] .= '</div></div>';
                // $nestedData['action'] = '<div class="m-1.5"><a class="btn btn-sm border-slate-200 hover:border-slate-300 text-slate-600" href="'.route('admin.role.attach.permission',$mfi->id).'"><svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16"><path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" /></svg><span class="ml-2">Permissions</span></a></div>';
                $data[] = $nestedData;
                $nestedData = [];
            }
        }

        $jsonData = array(
            "draw" => (int) $request->input('draw'),
            "recordsTotal" => (int) $totalData,
            "recordsFiltered" => (int) $totalFiltered,
            "data" => $data,
        );

        return response()->json($jsonData);
        // }catch(\Exception $e){
        //     logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
        //     return $this->responseJson(false,500,"Something went wrong");
        // }

    }
    public function getPermissions(Request $request)
    {
        try {
            $totalData = $this->roleService->getTotalPermissionData();
            $totalFiltered = $totalData;
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'name';
            $dir = 'asc';
            $index = $start;
            $nestedData = [];
            $data = [];
            if (empty($request->input('search.value'))) {
                $permissions = $this->roleService->getPermissionList($start, $limit, $order, $dir);
            } else {
                $search = $request->input('search.value');
                $permissions = $this->roleService->getPermissionList($start, $limit, $order, $dir, $search);
                $totalFiltered = $this->roleService->getTotalPermissionData($search);
            }
            // dd($permissions);
            $data = array();
            if (!empty($permissions)) {
                foreach ($permissions as $permission) {
                    $index++;
                    $nestedData['sr'] = $index;
                    $nestedData['id'] = $permission->id;
                    $nestedData['name'] = $permission->name;
                    $nestedData['slug'] = $permission->slug;
                    $data[] = $nestedData;
                    $nestedData = [];
                }
            }

            $jsonData = array(
                "draw" => (int) $request->input('draw'),
                "recordsTotal" => (int) $totalData,
                "recordsFiltered" => (int) $totalFiltered,
                "data" => $data,
            );

            return response()->json($jsonData);
        } catch (\Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something went wrong");
        }
    }

    public function getSubCategories(Request $request)
    {
        if ($request->ajax()) {
            $isCategory = $this->categoryService->findCategoryById($request->id);
            if ($isCategory && $isCategory->descendants->isNotEmpty()) {
                foreach ($isCategory->descendants->toTree() as $key => $children) {
                    $subCategory[$children->id]['name'] = $children->name;
                    if ($children->children->isNotEmpty()) {
                        $subCategory[$children->id]['children'] = $children->children->pluck('name', 'id');
                    }
                }
                return $this->responseJson(true, 200, 'Data Found successfully', $subCategory);
            } else {
                return $this->responseJson(false, 200, 'No Data Found');
            }
        } else {
            abort(403);
        }
    }

    public function getState(Request $request)
    {
        $countryId = Country::where('name', $request->country_name)->value('id');
        $data['states'] = State::where("country_id", $countryId)
            ->get(["name", "id"]);
        return response()->json($data);
    }
    public function getCity(Request $request)
    {
        if (!empty($request->states_name) && is_array($request->states_name)) {
            $stateIds = State::whereIn('name', $request->states_name)->pluck('id')->toArray();
            $data['cities'] = City::whereIn("state_id", $stateIds)
                ->get(["name", "id"]);
        } else {
            $stateId = State::where('name', $request->state_name)->value('id');
            $data['cities'] = City::where("state_id", $stateId)
                ->get(["name", "id"]);
        }

        //dd($data['cities']);
        return response()->json($data);
    }

    public function setStatus(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            $data = $request->value;
            $mfiroleid = $request->value;
            switch ($table) {
                case 'users':
                    $request->merge($data);
                    // dd($request->all());
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->userService->updateUserStatus($request->except(['uuid', 'find', 'value']), $id);
                    $message = 'User Status updated';
                    break;

                case 'plan_categories':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->updateStatus($request->except('find'), $id);
                    $message = 'Category Status updated';
                    break;


                case 'categories':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->updateCategoryStatus($request->except('find'), $id);
                    $message = 'Category Status updated';
                    break;
                case 'rewards':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->faqService->updateRewardStatus($request->except('find'), $id);
                    $message = 'Reward Status updated';
                    break;
                case 'customer_demands':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->userService->updateDemandStatus($request->except('find'), $id);
                    $message = 'Demand Status updated';
                    break;
                case 'pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->pageService->updatePage($request->except('find'), $id);
                    $message = 'Page Status updated';
                    break;
                case 'attributes':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->updateAttributeStatus($request->except('find'), $id);
                    $message = 'Attribute Status updated';
                    break;
                case 'banners':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->bannerService->updateBanner($request->except('find'), $id);
                    $message = 'Banner Status updated';
                    break;
                case 'menus':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->menuService->updateMenu($request->except('find'), $id);
                    $message = 'Banner Status updated';
                    break;
                case 'products':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->productService->updateProductStatus($request->except('find'), $id);
                    $message = 'Product Status updated';
                    break;
                case 'brands':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->brandService->updateBrandStatus($request->except('find'), $id);
                    $message = 'Brand Status updated';
                    break;
                case 'courses':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->brandService->updateCourseStatus($request->except('find'), $id);
                    $message = 'Course Status updated';
                    break;
                case 'blogs':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->blogService->updateBlogStatus($request->except('find'), $id);
                    $message = 'Blog Status updated';
                    break;
                case 'faqs':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->faqService->updateFaqStatus($request->except('find'), $id);
                    $message = 'Faq Status updated';
                    break;
                case 'reviews':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->testimonialService->updateTestimonialStatus($request->except('find'), $id);
                    $message = 'Testimonial Status updated';
                    break;
                case 'coupons':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->couponService->setCouponStatus($request->except('find'), $id);
                    $message = 'Coupon Status updated';
                    break;
                case 'stores':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->storeService->updateStoreStatus($request->except('find'), $id);
                    $message = 'Store Status updated';
                    break;
                case 'branches':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->branchService->updateBranchStatus($request->except('find'), $id);
                    $message = 'Branch Status updated';
                    break;
                case 'groups':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->agentGroupService->updateGroupStatus($request->except('find'), $id);
                    $message = 'Group Status updated';
                    break;
                case 'loans':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->loanService->updateLoanStatus($request->except('find'), $id);
                    $message = 'Loan Status updated';
                    break;

                case 'purposes':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->purposeService->updatePurposeStatus($request->except('find'), $id);
                    $message = 'Purpose Status updated';
                    break;
                case 'occupations':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->occupationService->updateOccupationStatus($request->except('find'), $id);
                    $message = 'Occupation Status updated';
                    break;
                case 'accounts':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->accountService->updateAccountStatus($request->except('find'), $id);
                    $message = 'Account Status updated';
                    break;
                case 'leads':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->leadService->updateLeadStatus($request->except('find'), $id);
                    $message = 'Lead Status updated';
                    break;
                case 'roles':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->roleService->updateRoleStatus($request->except('find'), $id);
                    $message = 'Role Status updated';
                    break;
                case 'mfi_roles':
                    $id = $request->uuid;
                    $data = $this->roleService->updateMfiRoleStatus($request->except('find'), $id);
                    $message = 'Role Status updated';
                    break;
                default:
                    return $this->responseJson(false, 200, 'Something Wrong Happened');
            }

            if ($data) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        } else {
            abort(403);
        }
    }

    public function updateSales(Request $request)
    {
        $table = $request->find;
        $data = $request->value;
        $id = uuidtoid($request->uuid, $table);

        $product = Product::where('id', $id)->first();
        $product->is_sales = $data;
        $product->save();
        $message = 'Status updated';
        return $this->responseJson(true, 200, $message);
    }


    public function updateDeal(Request $request)
    {
        $table = $request->find;
        $data = $request->value;
        $id = uuidtoid($request->uuid, $table);
        $product = Product::where('id', $id)->first();
        $product->is_deal = $data;
        $product->save();
        $message = 'Status updated';
        return $this->responseJson(true, 200, $message);
    }


    public function deleteData(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;

            switch ($table) {
                case 'users':
                    $data = $this->userService->userDelete($request->except('find'));
                    $message = 'User Deleted';
                    break;
                case 'plan_categories':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->deleteCategory($id);
                    $message = 'Category Deleted';
                    break;
                case 'categories':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->deleteCategory($id);
                    $message = 'Category Deleted';
                    break;
                case 'attributes':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->categoryService->deleteAttribute($id);
                    $message = 'Attribute Deleted';
                case 'rewards':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->faqService->deleteReward($id);
                    $message = 'Reward Deleted';
                    break;
                case 'customer_demands':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->userService->deleteDemand($id);
                    $message = 'Demand Deleted';
                    break;
                case 'pages':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->pageService->deletePage($id);
                    $message = 'Page Deleted';
                    break;
                case 'banners':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->bannerService->deleteBanner($id);
                    $message = 'Banner Deleted';
                    break;
                case 'menus':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->menuService->deleteMenu($id);
                    $message = 'Menu Deleted';
                    break;
                case 'documents':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->userService->deleteDocument($id);
                    $message = 'Document Deleted';
                    break;
                case 'products':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->productService->deleteProduct($id);
                    $message = 'Product Deleted';
                    break;
                case 'brands':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->brandService->deleteBrand($id);
                    $message = 'Brand Deleted';
                    break;
                case 'courses':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->brandService->deleteCourse($id);
                    $message = 'Course Deleted';
                    break;
                case 'blogs':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->blogService->deleteBlog($id);
                    $message = 'Blog Deleted';
                    break;
                case 'groups':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->agentGroupService->deleteGroup($id);
                    $message = 'Group Deleted';
                    break;
                case 'faqs':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->faqService->deleteFaq($id);
                    $message = 'Faq Deleted';
                    break;
                case 'reviews':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->testimonialService->deleteTestimonial($id);
                    $message = 'Testimonial Deleted';
                    break;
                case 'coupons':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->couponService->deleteCoupon($id);
                    $message = 'Coupon Deleted';
                    break;
                case 'stores':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->storeService->deleteStore($id);
                    $message = 'Store Deleted';
                    break;
                case 'mfis':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->mfiService->deleteMfi($id);
                    $message = 'MFI Deleted';
                    break;
                case 'branches':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->branchService->deleteBranch($id);
                    $message = 'Branch Deleted';
                    break;
                case 'loans':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->loanService->deleteLoan($id);
                    $message = 'Loan Deleted';
                    break;
                case 'purposes':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->purposeService->deletePurpose($id);
                    $message = 'Purpose Deleted';
                    break;
                case 'occupations':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->occupationService->deleteOccupation($id);
                    $message = 'Occupation Deleted';
                    break;
                case 'accounts':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->accountService->deleteAccount($id);
                    $message = 'Account Deleted';
                    break;
                case 'leads':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->leadService->deleteLead($id);
                    $message = 'Lead Deleted';
                    break;
                case 'enquiries':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->enquiryService->deleteEnquiry($id);
                    $message = 'Enquiry Deleted';
                    break;
                case 'roles':
                    $id = uuidtoid($request->uuid, $table);
                    $data = $this->roleService->deleteRole($id);
                    $message = 'Branch Deleted';
                    break;
            }
            if ($data) {
                return $this->responseJson(true, 200, $message);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        } else {
            abort(403);
        }
    }
    public function editData(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            switch ($table) {

                case 'loans':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->loanService->findLoanById($id);
                    $data = new LoanResource($returnData);
                    $message = 'Loan Fetched';
                    break;
                case 'loan_emis':
                    $id = uuidtoid($request->uuid, 'loans');
                    $returnData = $this->loanService->findLoanEmisByLoanId($id);
                    $loan = $this->loanService->findLoanById($id);
                    $data = ['emis' => LoanEmiResource::collection($returnData), 'loan' => $loan];
                    $message = 'Loan Fetched';
                    break;
                case 'occupations':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->occupationService->findOccupationById($id);
                    $data = new OccupationResource($returnData);
                    $message = 'Occupation Fetched';
                    break;
                case 'customer_demands':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->userService->findDemandById($id);
                    $data = new DemandResource($returnData);
                    //dd($data);
                    $message = 'Demand Fetched';
                    break;
                case 'purposes':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->purposeService->findPurposeById($id);
                    $data = new PurposenResource($returnData);
                    $message = 'Purpose Fetched';
                    break;
                case 'branches':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->branchService->findBranchById($id);
                    $data = new BranchResource($returnData);
                    $message = 'Branch Fetched';
                    break;
                case 'groups':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->agentGroupService->findGroupById($id);
                    $data = new GroupResource($returnData);
                    $message = 'Group Fetched';
                    break;
                case 'branch_action_of_areas':
                    $id = uuidtoid($request->uuid, 'branches');
                    $returnData = $this->branchService->findBranchById($id);
                    $data = new BranchOprationAreaResource($returnData);
                    $message = 'Branch Action Of Area Fetched';
                    break;
                case 'customer_kyc_verifications':
                    $id = uuidtoid($request->uuid, 'users');
                    $returnData = $this->userService->findUser($id);
                    //dd($returnData);
                    $data = new CustomerKycResource($returnData);
                    $message = 'Customer Kyc Fetched';
                    break;
                case 'leads':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->leadService->findLeadById($id);
                    $data = new LeadResource($returnData);
                    $message = 'Lead Fetched';
                    break;
                case 'lead_customer':
                    $id = uuidtoid($request->uuid, 'leads');
                    $returnData = $this->leadService->findLeadById($id);
                    $data = new CustomerLeadResource($returnData);
                    $message = 'Lead Fetched';
                    break;
                case 'enquiries':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->enquiryService->findEnquiryById($id);
                    $data = new EnquiryResource($returnData);
                    $message = 'Enquiry Fetched';
                    break;
                case 'roles':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->roleService->findRoleById($id);
                    $data = new RoleResource($returnData);
                    $message = 'Role Fetched';
                    break;
                case 'users':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->userService->findUser($id);
                    //dd($returnData);
                    $data = new UserResource($returnData);
                    $message = 'User Fetched';
                    break;
                case 'accounts':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->accountService->findAccountById($id);
                    $data = new AccountResource($returnData);
                    $message = 'Account Fetched';
                    break;
                case 'customers':
                    $id = uuidtoid($request->uuid, "users");
                    $returnData = $this->userService->findUser($id);
                    $data = new CustomerResource($returnData);
                    $message = 'Customer Fetched';
                    break;
            }
            if ($data) {
                return $this->responseJson(true, 200, $message, $data);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        } else {
            abort(403);
        }
    }
    public function viewData(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            switch ($table) {

                case 'enquiries':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->enquiryService->findEnquiryById($id);
                    $data = new NotesResource($returnData);
                    $message = 'Enquiry Fetched';
                    break;
                case 'customer_demands':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->userService->findDemandById($id);
                    $data = new DemandNotesResource($returnData);
                    $message = 'Demand Status Fetched';
                    break;
                case 'occupations':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->occupationService->findOccupationById($id);
                    $data = new OccupationResource($returnData);
                    $message = 'Occupation Fetched';
                    break;
                case 'purposes':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->purposeService->findPurposeById($id);
                    $data = new PurposenResource($returnData);
                    $message = 'Purpose Fetched';
                    break;
                case 'branches':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->branchService->findBranchById($id);
                    $data = new BranchResource($returnData);
                    $message = 'Branch Fetched';
                    break;
                case 'branch_action_of_areas':
                    $id = uuidtoid($request->uuid, 'branches');
                    $returnData = $this->branchService->findBranchById($id);
                    $data = new BranchOprationAreaResource($returnData);
                    $message = 'Branch Fetched';
                    break;
                case 'leads':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->leadService->findLeadById($id);
                    $data = new LeadVerifyResource($returnData);
                    $message = 'Lead Fetched';
                    break;
                case 'roles':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->roleService->findRoleById($id);
                    $data = new RoleResource($returnData);
                    $message = 'Role Fetched';
                    break;
                case 'users':
                    $id = uuidtoid($request->uuid, $table);
                    $returnData = $this->userService->findUser($id);
                    //dd($returnData);
                    $data = new UserResource($returnData);
                    $message = 'User Fetched';
                    break;
            }
            if ($data) {
                return $this->responseJson(true, 200, $message, $data);
            } else {
                return $this->responseJson(false, 200, 'Something Wrong Happened');
            }
        } else {
            abort(403);
        }
    }
    public function editMfi(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->find;
            $id = uuidtoid($request->uuid, $table);
            $getMfiData = $this->mfiService->findMfiById($id);
            if ($getMfiData) {
                $returnData = new MfiResource($getMfiData);
                // $getMfiData->push($getMfiData->user);
                return $this->responseJson(true, 200, 'Data found successfully', $returnData);
            } else {
                abort(403);
            }
        }
    }

    public function updateSessionStatus(Request $request)
    {

        $session = LiveSession::where('id', $request->uuid)->first();
        $session->status = $request->value['is_active'];
        $session->save();
        if ($request->value['is_active'] == 1) {
            $massage = "Session Approved Successfully";
        } else if ($request->value['is_active'] == 0) {
            $massage = "Session Unapproved Successfully";
        }
        return $this->responseJson(true, 200, $massage);
    }

    public function restaurantSubcategory(Request $request)
    {
        dd($request->all());
        $subCategories = RestaurantsSubCategorie::where('category_id', $request->category_id)->get();
        return response()->json(['subCategories' => $subCategories]);
    }
}
