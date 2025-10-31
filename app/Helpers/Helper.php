<?php

namespace App\Helpers;

use \Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\permissions;
use KhmerDateTime\KhmerDateTime;
use Illuminate\Support\Facades\Auth;

class Helper
{
    /**
     * @param string $value
     * @param string $format
     * @return string
     * USAGE:
     * Helper::dateFormating($value, $format)
     */
    // GET DYNAMIC LANGUAGE
    static function getLang()
    {
        return app()->getLocale();
    }

    static function remove_file($imagePath){
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }


    static function upload_survey_base64($data_image,$path){
        if (strpos($data_image, 'base64') !== false) {
            $imageFile      = $data_image;
            $image_array_1  = explode(";", $imageFile);
            $image_array_2  = explode(",", $image_array_1[1]);
            $extension=explode("/",$image_array_1[0]);
            $ext=$extension[1];
            $fileContents   = base64_decode($image_array_2[1]);
            $imageName      = time().rand(1,100).".".$ext;
        }

        if (!file_exists(storage_path("/app/public/".$path))) {
            mkdir(storage_path("/app/public/".$path), 0777, true);
        }
        file_put_contents(storage_path("/app/public/".$path.$imageName) , $fileContents);
        $full_path = url("storage/".$path.$imageName);
        return [
            $full_path,
            $imageName,
        ];
    }

    static function upload_customer_base64($data_image,$path){
        if (strpos($data_image, 'base64') !== false) {
            $imageFile      = $data_image;
            $image_array_1  = explode(";", $imageFile);
            $image_array_2  = explode(",", $image_array_1[1]);
            $extension=explode("/",$image_array_1[0]);
            $ext=$extension[1];
            $fileContents   = base64_decode($image_array_2[1]);
            $imageName      = time().rand(1,100).".".$ext;
        }

        if (!file_exists(storage_path("/app/public/".$path))) {
            mkdir(storage_path("/app/public/".$path), 0777, true);
        }
        file_put_contents(storage_path("/app/public/".$path.$imageName) , $fileContents);
        $full_path = url("storage/".$path.$imageName);
        $name = $imageName;
        return [
            $full_path,
            $name
        ];
    }
    static function upload_user_base64($data_image,$path){
        if (strpos($data_image, 'base64') !== false) {
            $imageFile      = $data_image;
            $image_array_1  = explode(";", $imageFile);
            $image_array_2  = explode(",", $image_array_1[1]);
            $extension=explode("/",$image_array_1[0]);
            $ext=$extension[1];
            $fileContents   = base64_decode($image_array_2[1]);
            $imageName      = time().rand(1,100).".".$ext;
        }

        if (!file_exists(storage_path("/app/public/".$path))) {
            mkdir(storage_path("/app/public/".$path), 0777, true);
        }
        file_put_contents(storage_path("/app/public/".$path.$imageName) , $fileContents);
        $full_path = url("storage/".$path.$imageName);
        return $full_path;
    }
    static function is_base64($data_image){
        $image_url=explode(";",$data_image);
        if(count($image_url)>1){
            return true;
        }
        return false;
    }
    static function get_survey_file_path(){
        if(auth()->check()){
            $path='survey/files/';
            return $path;
        }
    }
    static function get_pre_survey_file_path(){
        if(auth()->check()){
            $path='presurvey/files/';
            return $path;
        }
    }
    static function get_customer_file_path(){
        if(auth()->check()){
            $path='customer/files/';
            return $path;
        }
    }
    static function get_user_profile_path(){
        if(auth()->check()){
            $path='users/profiles/';
            return $path;
        }
    }
    static function get_file_manager_path(){
        if(auth()->check()){
            $path='app/public/files/';
            return $path;
        }
    }
    static function http_image($data_image){
        $image_url = explode(":",$data_image);
        if($image_url[0]=="http"||$image_url[0]=="https"){
            return true;
        }
        return false;
    }

}
