<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;
use File;


use FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use FFMpeg\Filters\Video\ClipFilter;

/**
 * Trait UploadAble
 * @package App\Traits
 */
trait UploadAble
{

    public function createImageFromBase64($base64Code, $folder = null, $fileName = null, $storageDisk = 'public', array $resizeFolder = []){
       
        $imageParts   = explode(";base64,", $base64Code);
        $imageTypeAux = explode("image/", $imageParts[0]);

        if(count($imageParts)==1)
        {
            $imageBase64  = base64_decode($imageParts[0]);
        }else
        {
            $imageType    = $imageTypeAux[1];

            $imageBase64  = base64_decode($imageParts[1]);
        }

        
        $file         = $folder ."/". $fileName;
        $shortPath    = strstr($folder, "images");

        if(!Storage::exists($folder)){
            Storage::disk('public')->makeDirectory($shortPath);
        }

        if(!file_exists($file)){
            $isOrignalFileUploaded = Storage::disk('public')->put($file, $imageBase64);
            if($isOrignalFileUploaded){
                if($storageDisk == 's3'){
                    $saveInBucket = Storage::disk($storageDisk)->put($shortPath.$fileName, $localImage);
                    if($saveInBucket){
                        //unlink($file);
                        return true;
                    }
                }

                $orignalImagePath = Storage::disk('public')->path($file);

                $fileVariations = [
                    'COVER_IMAGE' => [
                        'path' => config('constants.SITE_COVER_IMAGE_UPLOAD_PATH'),
                        'size' => explode('x', config('constants.SITE_COVER_IMAGE_DIMENSION'))
                    ],
                    'PROFILE_IMAGE' => [
                        'path' => config('constants.SITE_PROFILE_IMAGE_UPLOAD_PATH'),
                        'size' => explode('x', config('constants.SITE_PROFILE_IMAGE_DIMENSION'))
                    ],
                    'THUMBNAIL_IMAGE' => [
                        'path' => config('constants.SITE_THUMBNAIL_IMAGE_UPLOAD_PATH'),
                        'size' => explode('x', config('constants.SITE_THUMBNAIL_IMAGE_DIMENSION'))
                    ]
                ];

                if(!empty($resizeFolder)){
                    foreach($resizeFolder as $resizeType){
                        $isFileProcessed = $this->imageResizeAndSave($orignalImagePath, $fileName, $fileVariations[$resizeType], $storageDisk);

                        if(!$isFileProcessed){
                            return false;
                        }
                    }
                }

                return true;
            }
        }else{
            return false;
        }
    }

    public function base64FileUpload($file, $path, $resizeWidth = NULL, $resizeHeight = NULL)
    {
        list($type, $data) = explode(';', $file);
        $extSplit = explode('/', $type);
        $ext      =  $extSplit[1];
        $extType  =  $extSplit[0];
        $fileName = uniqid() . '.' .  $ext;

        if (!File::exists(\Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $path)) {
            File::makeDirectory(\Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $path, 0755, true);
        }

        $save_path  = \Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix() . $path . '/' . $fileName;
        $image      = base64_decode(preg_replace($this->pregReplaceStringForBase64EncodedType($extType), '', $file));
        file_put_contents($save_path, $image);

        // resize image
        if (!empty($resizeWidth) || !empty($resizeHeight)) {
            // create instance
            try {
                $img = \Image::make($save_path);

                // RESIZE BY WIDTH
                if (!empty($resizeWidth)) {
                    $img->resize($resizeWidth, NULL);
                    // RESIZE BY HEIGHT
                } else if (!empty($resizeHeight)) {
                    $img->resize(NULL, $resizeHeight);
                }
                $img->save($save_path);
            } catch (\Exception $e) {
                // throw $e;
            }
        }

        // Store S3 file
        // $this->storeS3File($path . '/' . $fileName, $image);

        return ['path' => $path . '/' . $fileName, 'name' => $fileName];
    }

    /**
     * @param UploadedFile $file
     * @param null $folder
     * @param string $disk
     * @param null $filename
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, $fileName = null, $storageDisk = 'public', array $resizeFolder = [])
    {
        $fileName       = !is_null($fileName) ? $fileName : uniqid();
        $fileExtension  = $file->extension();
        $fileVariations = [
            'POST_IMAGE' => [
                'path' => config('constants.SITE_POST_IMAGE_UPLOAD_PATH'),
                'size' => explode('x', config('constants.SITE_POST_IMAGE_DIMENSION'))
            ],
            'COLLECTION_IMAGE' => [
                'path' => config('constants.SITE_COLLECTION_IMAGE_UPLOAD_PATH'),
                'size' => explode('x', config('constants.SITE_COLLECTION_IMAGE_DIMENSION'))
            ],
            'COVER_IMAGE' => [
                'path' => config('constants.SITE_COVER_IMAGE_UPLOAD_PATH'),
                'size' => explode('x', config('constants.SITE_COVER_IMAGE_DIMENSION'))
            ],
            'PROFILE_IMAGE' => [
                'path' => config('constants.SITE_PROFILE_IMAGE_UPLOAD_PATH'),
                'size' => explode('x', config('constants.SITE_PROFILE_IMAGE_DIMENSION'))
            ],
            'THUMBNAIL_IMAGE' => [
                'path' => config('constants.SITE_THUMBNAIL_IMAGE_UPLOAD_PATH'),
                'size' => explode('x', config('constants.SITE_THUMBNAIL_IMAGE_DIMENSION'))
            ],
            'PHOTO_STORE_IMAGE' => [
                'path' => config('constants.SITE_PHOTO_STORE_IMAGE_UPLOAD_PATH'),
                'size' => explode('x', config('constants.SITE_PHOTO_STORE_IMAGE_DIMENSION'))
            ]
        ];

        $isOrignalFileUploaded = $file->storeAs(
            $folder,
            $fileName,
            $storageDisk
        );

        if($isOrignalFileUploaded){
            if(!empty($resizeFolder)){
                foreach($resizeFolder as $resizeType){
                    if(in_array($fileExtension, ['mp4'])){
                        // $isFileProcessed = $this->makeVideoTrailerAndSave($storageDisk, $fileName, $resizeType);
                        $isFileProcessed = true;

                        if(!$isFileProcessed){
                            return false;
                        }
                    }else if(in_array($fileExtension, ['jpg', 'jpeg', 'png'])){
                        $isFileProcessed = $this->imageResizeAndSave($file, $fileName, $fileVariations[$resizeType], $storageDisk);

                        if(!$isFileProcessed){
                            return false;
                        }
                    }
                }
            }

            return true;
        }else{
            return false;
        }
    }



    /**
     * @param null $path
     * @param string $disk
     */
    public function deleteOne($path = null, $disk = 'public')
    {
        Storage::disk($disk)->delete($path);
    }

    /**
     * @param null $old_path
     * @param null $new_path
     * @param string $disk
     */
    public function copyOne($old_path = null, $new_path = null, $disk = 'public')
    {
        $contents = Storage::disk($disk)->copy($old_path, $new_path);
        Log::debug('File '.print_r($contents, true));

    }

    private function makeVideoTrailerAndSave($storageDisk, $fileName){
        try{
            if($storageDisk != 'public'){
                Storage::makeDirectory('public/'. config('constants.SITE_VIDEO_TRAILER_UPLOAD_PATH'));
            }

            $clipStartingTime = TimeCode::fromSeconds(config('constants.SITE_VIDEO_TRAILER_CLIP_STARTING_TIME_IN_SEC'));
            $clipDuration     = TimeCode::fromSeconds(config('constants.SITE_VIDEO_TRAILER_CLIP_DURATION'));
            $clipFilter       = new ClipFilter($clipStartingTime, $clipDuration);

            if($storageDisk == 's3'){
                FFMpeg::fromDisk($storageDisk)
                    ->open(config('constants.SITE_VIDEO_UPLOAD_PATH') . $fileName)
                    ->addFilter($clipFilter)
                    ->export()
                    ->toDisk($storageDisk)
                    ->withVisibility('public')
                    ->inFormat(new X264('copy', 'libx264'))
                    ->save(config('constants.SITE_VIDEO_TRAILER_UPLOAD_PATH'). $fileName);
            }else{
                FFMpeg::fromDisk($storageDisk)
                    ->open(config('constants.SITE_VIDEO_UPLOAD_PATH') . $fileName)
                    ->addFilter($clipFilter)
                    ->export()
                    ->toDisk($storageDisk)
                    ->inFormat(new X264('copy', 'libx264'))
                    ->save(config('constants.SITE_VIDEO_TRAILER_UPLOAD_PATH'). $fileName);
            }

            return true;
        }catch(\Exception $e){
            logger($e->getMessage());
            return false;
        }
    }

    private function imageResizeAndSave($file, $fileName, $fileVariations, $storageDisk)
    {
        try{
            $image = Image::make($file)
                        ->resize($fileVariations['size'][0], $fileVariations['size'][1],
                            function($constraint){
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            }
                        );

            Storage::disk($storageDisk)->put($fileVariations['path']. $fileName, $image->stream());
            return true;
        }catch(\Exception $e){
            logger($e->getMessage());
            return false;
        }
    }




}
