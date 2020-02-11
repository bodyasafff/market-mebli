<?php

namespace App\Repositories\Base;

use App\Models\Log;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;

class FileRepository
{
    static function filesDelete($urls, $storagePath = '')
    {
        if(!empty($urls)){
            foreach ($urls as $url){
                self::fileDelete($url, $storagePath);
            }
        }
    }

    static function fileDelete($url = false, $storagePath = '')
    {
        if(!empty($url)){
            $storageFilePath = config('filesystems.disks.public.root').'/'.$storagePath.self::getFileNameFromUrl($url);
            //unlink($storageFilePath);
            /*try{

            }catch (Exception $e){}*/

            if(file_exists($storageFilePath)){
                unlink($storageFilePath);
            }

            //\Storage::disk('public')->delete(self::getFileNameFromUrl($url));
        }
    }

    static function getRandomName($extension = 'jpg')
    {
        return str_replace('.', '_', (9999999999-(time()+microtime(true)))).'.'.$extension;
    }

    static function getFileNameFromUrl($url)
    {
        return pathinfo($url, PATHINFO_BASENAME);
    }

    static function downloadFromUrl($url, $contentTypes = [], $recall = 0)
    {
        try{
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_BUFFERSIZE, 128);
            curl_setopt($curl, CURLOPT_NOPROGRESS, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_PROGRESSFUNCTION, function(
                $DownloadSize, $Downloaded, $UploadSize, $Uploaded
            ){
                return ($Downloaded > (2 * 1000000)) ? 1 : 0;
            });
            $file = curl_exec($curl);

            $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

            curl_close($curl);

            if(!empty($contentTypes)){
                if(!in_array($contentType, $contentTypes)){
                    return null;
                }
            }

            return $file;
        } catch (\Exception $e) {
            if(!$recall || $recall < 10){
                sleep(1);
                return self::downloadFromUrl($url, $contentTypes, $recall+1);
            }
        }

        return null;
    }

    static function saveImageFromUrl($url = null, $storagePath = '', $imageName = false, $width = 320, $height = null, $extension = 'jpg')
    {
        if(!empty($url)){
            $image = self::downloadFromUrl($url, [
                'image/jpeg',
                'image/png',
                'image/gif',
            ]);
            return FileRepository::saveImage($image, $storagePath, $imageName, $width, $height, $extension);
        }

        return null;
    }

    static function saveImage($image = null, $storagePath = '', $imageName = false, $width = 320, $height = null, $extension = 'jpg')
    {
        if(empty($image)){
            return null;
        }
        $imageUrl = !empty($imageName) ? $imageName.'.'.$extension : self::getRandomName($extension);

        if($width){
            if (extension_loaded('imagick')){
                Image::configure(['driver' => 'imagick']);
            }

            if(is_array($storagePath)){
                $imageUrls = [];
                $imageOrigin = $image;
                foreach ($storagePath as $i => $storagePathItem){

                    $isHeight = false;
                    if(is_array($height)){
                        if(!empty($height[$i])){
                            $isHeight = $height[$i];
                        }
                    }else if(!empty($height)){
                        $isHeight = $height;
                    }

                    $isWidth = false;
                    if(is_array($width)){
                        if(!empty($width[$i])){
                            $isWidth = $width[$i];
                        }
                    }else if(!empty($width)){
                        $isWidth = $width;
                    }

                    try{
                        if($isHeight && $isWidth) {
                            $image = Image::make($imageOrigin)->orientate()->fit($isWidth, $isHeight)->encode($extension, 70);
                        }else if($isHeight){
                            $image = Image::make($imageOrigin)->orientate()->heighten($isHeight)->encode($extension, 70);
                        }else{
                            $isWidth = is_array($width) ? $width[$i] : $width*($i+1);
                            $image = Image::make($imageOrigin)->orientate()->widen($isWidth)->encode($extension, 70);
                        }

                        Storage::disk('public')->put($storagePath[$i].$imageUrl, (string)$image);
                        $imageUrls[$i] = !empty($imageUrl) ? \App\Application::imageAsset('storage/'.$storagePath[$i].$imageUrl) : $imageUrl;
                    } catch (\Exception $e) {

                        Log::add([
                            'event'       => Log::EVENT_TRY_CATCH,
                            'status'      => Log::STATUS_ERROR,
                            'description' => 'FileRepository::saveImage | '.$imageName,
                        ]);

                        $imageUrls = null;
                    }
                }
                return $imageUrls;
            }else{
                if(!empty($width) && !empty($height)){
                    $image = Image::make($image)->orientate()->fit($width, $height)->encode($extension, 70);
                }else if(!empty($height)){
                    $image = Image::make($image)->orientate()->heighten($height)->encode($extension, 70);
                }else{
                    $image = Image::make($image)->orientate()->widen($width)->encode($extension, 70);
                }
                try{
                    Storage::disk('public')->put($storagePath.$imageUrl, (string)$image);
                    return !empty($imageUrl) ? \App\Application::imageAsset('storage/'.$storagePath.$imageUrl) : $imageUrl;
                } catch (\Exception $e) {
                    return null;
                }
            }
        }else{
            try{
                Storage::disk('public')->put($storagePath.$imageUrl, (string)$image);
                return !empty($imageUrl) ? \App\Application::imageAsset('storage/'.$storagePath.$imageUrl) : $imageUrl;
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    static function getimagesize($imageUrl)
    {
        if(empty($imageUrl)){
            return null;
        }

        $imageData = getimagesize($imageUrl);
        return (object)[
            'url' => $imageUrl,
            'width' => $imageData[0],
            'height' => $imageData[1],
        ];
    }
}