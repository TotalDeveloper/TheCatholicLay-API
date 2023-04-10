<?php

namespace App\GraphQL\Mutations;

use Illuminate\Http\UploadedFile;

class Upload
{
    /**
     * Upload a file, store it on the server and return the path.
     *
     * @param  mixed  $root
     * @param  array<string, mixed>  $args
     * @return string|null
     */
    public function __invoke($root, array $args): ?string
    {
        /** @var UploadedFile $file */
        $file = $args['file'];

        // File is save under "public/storage/public/photo-uploads"
        return basename($file->storePublicly('public/photo-uploads'));
    }
}
