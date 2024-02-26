<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Diet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'gender',
        'age_from',
        'age_to',
        'height_from',
        'height_to',
        'weight_from',
        'weight_to',
        'bmi_from',
        'goal',
        'diet',
        'medical_condition',
        'allergy',
        'breakfast_calories',
        'lunch_calories',
        'snack_calories',
        'dinner_calories',
        'status',
        'created_at',
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    public function breakfasts()
    {
        return $this->belongsToMany(Food::class, 'diet_breakfasts');
    }

    public function foods():BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'diet_breakfasts', 'diet_id','food_id');
    }


   

    public function dietAnyBreakfasts()
    {
        return $this->belongsToMany(Food::class, 'diet_any_breakfasts');
    }

    public function lunches()
    {
        return $this->belongsToMany(Food::class, 'diet_lunches');
    }

    public function dietAnyLunches()
    {
        return $this->belongsToMany(Food::class, 'diet_any_lunches');
    }

    public function snacks()
    {
        return $this->belongsToMany(Food::class, 'diet_snacks');
    }

    public function dietAnySnacks()
    {
        return $this->belongsToMany(Food::class, 'diet_any_snacks');
    }

    public function dinners()
    {
        return $this->belongsToMany(Food::class, 'diet_dinners');
    }

    public function dietAnyDinners()
    {
        return $this->belongsToMany(Food::class, 'diet_any_dinners');
    }

    protected function breakfastImage($type='original'){
        $file= $this->image?->file;
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/banner/' . $file))){
                    return asset('storage/images/' . $type . '/banner/' . $file);
                }
            }
        }
        return asset('assets/frontend/images/banner-img1.png');
    }
}
