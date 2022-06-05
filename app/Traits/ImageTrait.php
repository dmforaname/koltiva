<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ImageTrait
{
    public function storeImageToStorage($request, $file, $folder = null)
    {
        $newFolder = ($folder)?'public/images/'.$folder : 'public/images';
        
        Storage::makeDirectory($newFolder);

        $image = $request->file($file);
        $path = Storage::putFile($newFolder, $image);
        $url = Storage::url($path);

        return $url;
    }
    
    /**
     * Remove Image from storage.
     *
     * @param string $path
     */
    public function removeImage($path)
    {
        // $realPath = str_replace("/storage/","public/", str_ireplace(config("app.url") ,"",$path) );
        Log::info($path);
        $newPath = str_replace("storage/","public/",$path);
        Log::info($newPath);

        $storage = Storage::delete($newPath);

        return true;
    }
}
