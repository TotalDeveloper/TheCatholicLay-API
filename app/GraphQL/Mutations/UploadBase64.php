<?php

namespace App\GraphQL\Mutations;
use Illuminate\Support\Facades\Storage;


final class UploadBase64
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        try {
            //code...
            $data = $args["input"]["base64"];
            $folderPath = "photo-uploads/";

            if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                $data = substr($data, strpos($data, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
            
                if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                    return [
                        'success' => 'false',
                        'message' => 'invalid image type' 
                    ];
                }
                $data = str_replace( ' ', '+', $data );
                $data = base64_decode($data);
            
                if ($data === false) {
                    return [
                        'success' => 'false',
                        'message' => 'base64_decode failed' 
                    ];
                }
            } else {
                return [
                    'success' => 'false',
                    'message' => 'did not match data URI with image data' 
                ];
            }
            
            $basePath = env('PHOTO_UPLOADS_BASE_URL');
            $fileName = uniqid() . '.png';

            $storage = Storage::put("$basePath/".$fileName, $data);

            return [
                'success' => 'true',
                'message' => $fileName
            ];
        } catch (\Throwable $th) {
            return [
                'success' => 'false',
                'message' => 'Error uploading image in the server.'. json_encode($th) 
            ];
        }
    }
}
