<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class CustomerDemand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'mfi_id',
        'agent_id',
        'loan_amount',
        'tenure',
        'group_id',
        'emi_start_date',
        'frequency',
        'loan_id',
        'remarks',
        'demand_status',
        'disbursement_status',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
       /*  self::deleting(function ($query) { // before delete() method call this
            $query->videoLinks()->delete();
        }); */

    }

    public function loan()
    {
        return $this->belongsTo(Loan::class,'loan_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id');
    }
    public function agent()
    {
        return $this->belongsTo(User::class,'agent_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function createdUser()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function note(){
        return $this->hasOne(CustomerDemandNotes::class,'demand_id');
    }

    public function demandNotes(){
        return $this->hasMany(CustomerDemandNotes::class,'demand_id');
    }

    /* public function media()
    {
        return $this->hasMany(Media::class, 'mediaable_id', 'id');
    }

    public function getKycPictureAttribute()
    {
        return $this->kycPicture('original/user');
    }

    public function videoLinks()
    {
        return $this->hasMany(CustomerKycVideoLink::class, 'kyc_id');
    }

    public function kycPicture($type = 'profile')
    {
        $profilePicture = $this->media()->where('reference_type', '=', 'kyc_image')->value('file');
        // return $profilePicture;
        if (!is_null($profilePicture)) {
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if ($fileDisk == 'public') {
                if (file_exists(public_path('storage/images/' . $type . '/' . $profilePicture))) {
                    return asset('storage/images/' . $type . '/' . $profilePicture);
                }
            }
        }
        return asset('assets/images/pro_img.jpg');
    } */
}
