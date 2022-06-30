<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    protected static function __uploadImage($image, $path = null, $thumbnail = false) {
        // dd($image);
        // dd($path);
        if ($path === null)
            $path = public_path('vendor');
        $digits = 3;
        $imageName = time() . rand(pow(10, $digits - 1), pow(10, $digits) - 1) . '.' . $image->getClientOriginalExtension();
        $image->move($path, $imageName);
//               ***************generate Thumbnail image start ********************* *
        if ($thumbnail === true):
            $path .= '/';
            $img = \Intervention\Image\ImageManagerStatic::make($path . $imageName)->resize(320, 240);
            $img->save($path . 'thumbnail_' . $imageName);
        endif;
//        /          ***************generate Thumbnail image end ********************* */
        return $imageName;
    }
    
    
}
