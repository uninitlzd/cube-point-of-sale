<?php
namespace App\Helpers;
use Closure;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Intervention\Image\Constraint;
use Symfony\Component\HttpFoundation\File\UploadedFile;
class FileHelper
{
    /**
     * Save the uploaded image.
     *
     * @param UploadedFile $file Uploaded file.
     * @param int $maxWidth
     * @param string $path
     * @param null $fileName
     * @return string File name.
     */
    public static function saveImage(UploadedFile $file, $maxWidth = 150, $path = null)
    {
        if (!$path) {
            $path = config('filesystems.uploads.images');
        }

        $fileName = self::getFileName($file);
        $img = self::makeImage($file);
        $img = self::resizeImage($img, $maxWidth);
        self::uploadImage($img, $fileName, $path);
        return $path.$fileName;
    }

    public static function saveBase64Image($file, $maxWidth = 150, $path = null) {
        $fileName = time();
        $img = self::makeImage($file);
        $img = self::resizeImage($img, $maxWidth);
        self::uploadImage($img, $fileName, $path);
        return $path.$fileName;
    }
    /**
     * Get uploaded file's name.
     *
     * @param UploadedFile $file
     *
     * @return null|string
     */
    protected static function getFileName(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();
        $filename = date('YmdHis') . '_products.' . pathinfo($filename, PATHINFO_EXTENSION);
        return $filename;
    }
    /**
     * Create the image from upload file.
     *
     * @param UploadedFile $file
     *
     * @return \Intervention\Image\Image
     */
    protected static function makeImage($file)
    {
        return Image::make($file);
    }
    /**
     * Resize image to the configured size.
     *
     * @param \Intervention\Image\Image $img
     * @param int                       $maxWidth
     *
     * @return \Intervention\Image\Image
     */
    protected static function resizeImage(\Intervention\Image\Image $img, $maxWidth = 150)
    {
        $img->resize($maxWidth, null, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        return $img;
    }
    /**
     * Save the uploaded image to the file system.
     *
     * @param \Intervention\Image\Image $img
     * @param string                    $fileName
     * @param string                    $path
     */
    protected static function uploadImage($img, $fileName, $path)
    {
        $img->save(public_path($path . $fileName));
    }

    /**
     * @param $path
     * @return bool
     */
    public static function removeImage($path)
    {
        return File::delete(public_path($path));
    }
}
