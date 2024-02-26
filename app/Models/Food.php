<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;


class Food extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'food';
    protected $fillable = [
        'uuid',
        'name',
        'food_type',
        'quantity',
        'food_make',
        'food_type_option',
        'food_suffix',
        'is_optional',
        'breakfast_callories',
        'lunch_callories',
        'dinner_callories',
        'snack_callories',
        'carbs',
        'proteins',
        'fats',
        'fibre',
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

    public function food()
    {
        return $this->morphOne(FoodMedia::class, 'mediaable');
    }

    public function dietBreakfasts():BelongsToMany
    {
        return $this->belongsToMany(Diet::class, 'diet_breakfasts', 'food_id');
    }

    public function dietLunches()
    {
        return $this->belongsToMany(Diet::class, 'diet_lunches');
    }
    public function dietDinners()
    {
        return $this->belongsToMany(Diet::class, 'diet_dinners');
    }

    public function dietSnacks()
    {
        return $this->belongsToMany(Diet::class, 'diet_snacks');
    }
    public function getBreakfastImageAttribute(){
        return $this->foodBreakfastImage();
    }
    public function getLunchImageAttribute(){
        return $this->foodLunchImage();
    }
    public function getDinnerImageAttribute(){
        return $this->foodDinnerImage();
    }
    public function getSnackImageAttribute(){
        return $this->foodSnackImage();
    }
    protected function foodBreakfastImage($type='original'){
        $file =  $this->food()->where('media_type', '=', 'breakfast')->value('file');
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/food/' . $file))){
                    return asset('storage/images/' . $type . '/food/' . $file);
                }
            }
        }
        return asset('assets/admin/images/default_food.jpg');
    }
    protected function foodLunchImage($type='original'){
        $file =  $this->food()->value('file');
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/food/' . $file))){
                    return asset('storage/images/' . $type . '/food/' . $file);
                }
            }
        }
        return asset('assets/admin/images/default_food.jpg');
    }
    protected function foodDinnerImage($type='original'){
        $file =  $this->food()->where('media_type', '=', 'dinner')->value('file');
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/food/' . $file))){
                    return asset('storage/images/' . $type . '/food/' . $file);
                }
            }
        }
        return asset('assets/admin/images/default_food.jpg');
    }
    protected function foodSnackImage($type='original'){
        $file =  $this->food()->where('media_type', '=', 'snack')->value('file');
        if($file){
            $fileDisk = config('constants.SITE_FILE_STORAGE_DISK');
            if($fileDisk == 'public'){
                if(file_exists(public_path('storage/images/' . $type . '/food/' . $file))){
                    return asset('storage/images/' . $type . '/food/' . $file);
                }
            }
        }
        return asset('assets/admin/images/default_food.jpg');
    }

    public function foodDetails()
    {
        return $this->hasOne(FoodItems::class, 'food_id');
    }

    public function foodItemsDetails()
    {
        return $this->hasMany(FoodItems::class, 'food_id');
    }

    public function FoodItems()
    {
        return $this->hasMany(FoodItems::class, 'food_id');
    }

}
