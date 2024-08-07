<?php

namespace App\Actions;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UploadFile
{

    public static function image(UploadedFile $file, string $folder = '', string|null $extension = null): false|string
    {
        return self::file($file, $folder);
    }

    public static function file(UploadedFile $file, string $folder = '', string|null $extension = null): false|string
    {
        $name = self::name(
            $file->getClientOriginalName(),
            $extension ?: $file->getClientOriginalExtension()
        );

        $folder = 'uploads' . (!empty($folder) ? '/' . $folder : '');

        return $file->storeAs($folder, $name, 'public');
    }

    protected static function name(string $name, string $extension): string
    {
        return sprintf(
            '%s_%d-%s.%s',
            Str::slug(pathinfo($name, PATHINFO_FILENAME)),
            date('YmdHi'),
            Str::random(2),
            $extension
        );
    }
}
