<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\File;

class DeleteUploadedPhoto
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        File::delete("storage/public/photo-uploads/" . $args['filename']);
    }
}
