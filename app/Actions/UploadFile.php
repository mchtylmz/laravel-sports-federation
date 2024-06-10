<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadFile
{

    public static function image(UploadedFile $file, string $folder = ''): false|string
    {
        $name = self::name(
            $file->getClientOriginalName(),
            $file->getClientOriginalExtension()
        );

        $folder = 'uploads' . (!empty($folder) ? '/' . $folder : '');

        return $file->storeAs($folder, $name, 'public');
    }

    protected static function name(string $name, string $extension): string
    {
        return sprintf(
            '%s_%d%s.%s',
            Str::slug(pathinfo($name, PATHINFO_FILENAME)),
            time(),
            Str::random(3),
            $extension
        );
    }
}
