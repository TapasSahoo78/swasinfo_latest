<?php

namespace App\Providers;

use App\Contracts\Account\AccountContract;
use App\Contracts\Group\AgentGroupContract;
use App\Contracts\Banner\BannerContract;
use App\Contracts\Blog\BlogContract;
use App\Contracts\Branch\BranchContract;
use App\Contracts\BranchOperationArea\BranchOperationAreaContract;
use App\Contracts\Brand\BrandContract;
use App\Contracts\Category\CategoryContract;
use App\Contracts\Coupon\CouponContract;
use App\Contracts\Enquiry\EnquiryContract;
use App\Contracts\Faq\FaqContract;
use App\Contracts\Lead\LeadContract;
use App\Contracts\Loan\LoanContract;
use App\Contracts\LoanEmi\LoanEmiContract;
use App\Contracts\Menu\MenuContract;
use App\Contracts\MfiRoles\MfiRolesContract;
use App\Contracts\Mfi\MfiContract;
use App\Contracts\Occupation\OccupationContract;
use App\Contracts\Page\PageContract;
use App\Contracts\Payment\PaymentContract;
use App\Contracts\Penalty\PenaltyContract;
use App\Contracts\Product\ProductContract;
use App\Contracts\Purpose\PurposeContract;
use App\Contracts\RestaurantContract\RestaurantContract;
use App\Contracts\Role\RoleContract;
use App\Contracts\Store\StoreContract;
use App\Contracts\Testimonial\TestimonialContract;
use App\Contracts\Users\InviteContract;

use App\Contracts\Users\UserContract;

use App\Repositories\Account\AccountRepository;
use App\Repositories\Banner\BannerRepository;
use App\Repositories\Blog\BlogRepository;
use App\Repositories\BranchOperationArea\BranchOperationAreaRepository;
use App\Repositories\Branch\BranchRepository;


use App\Repositories\Brand\BrandRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Enquiry\EnquiryRepository;
use App\Repositories\Faq\FaqRepository;
use App\Repositories\Lead\LeadRepository;
use App\Repositories\Loan\LoanRepository;
use App\Repositories\LoanEmi\LoanEmiRepository;
use App\Repositories\Menu\MenuRepository;
use App\Repositories\MfiRoles\MfiRolesRepository;
use App\Repositories\Mfi\MfiRepository;
use App\Repositories\Occupation\OccupationRepository;
use App\Repositories\Page\PageRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\Penalty\PenaltyRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Purpose\PurposeRepository;
use App\Repositories\Group\AgentGroupRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Store\StoreRepository;
use App\Repositories\Testimonial\TestimonialRepository;
use App\Repositories\Users\InviteRepository;

use App\Repositories\Users\UserRepository;

use Illuminate\Support\ServiceProvider;

/* use App\Contracts\Crm\Enquiry\EnquiryContract;
use App\Repositories\Crm\Enquiry\EnquiryRepository; */
use App\Contracts\Trainers\TrainerContract;
use App\Repositories\Product\RestaurantRepository;
use App\Repositories\Trainers\TrainerRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    protected $repositories = [



        UserContract::class => UserRepository::class,
        RoleContract::class => RoleRepository::class,
        InviteContract::class => InviteRepository::class,
        CategoryContract::class => CategoryRepository::class,
        BannerContract::class => BannerRepository::class,
        PageContract::class => PageRepository::class,
        ProductContract::class => ProductRepository::class,
        MenuContract::class => MenuRepository::class,
        CouponContract::class => CouponRepository::class,
        BrandContract::class => BrandRepository::class,
        BlogContract::class => BlogRepository::class,
        FaqContract::class => FaqRepository::class,
        TestimonialContract::class => TestimonialRepository::class,
        StoreContract::class => StoreRepository::class,
        PaymentContract::class => PaymentRepository::class,
        PenaltyContract::class => PenaltyRepository::class,
        MfiContract::class => MfiRepository::class,
        BranchContract::class => BranchRepository::class,
        BranchOperationAreaContract::class => BranchOperationAreaRepository::class,
        LoanContract::class => LoanRepository::class,
        LoanEmiContract::class => LoanEmiRepository::class,
        PurposeContract::class => PurposeRepository::class,
        OccupationContract::class => OccupationRepository::class,
        AccountContract::class => AccountRepository::class,
        EnquiryContract::class => EnquiryRepository::class,
        LeadContract::class => LeadRepository::class,
        MfiRolesContract::class => MfiRolesRepository::class,
        AgentGroupContract::class => AgentGroupRepository::class,
        TrainerContract::class => TrainerRepository::class,
        RestaurantContract::class => RestaurantRepository::class,


    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }





}
