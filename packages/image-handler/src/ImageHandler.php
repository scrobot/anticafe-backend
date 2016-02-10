<?php

namespace Pinerp\ImageHandler;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageServiceProvider;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ImageHandler
 * @package Yadeshevle\ImageHandler
 */

class ImageHandler extends Model {

    protected $fillable = [];
    
    protected $guarded = [];
    
    protected $table = 'images';

    protected $casts = [
        'preferences' => 'array',
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * @param File $file
     * @param array $object
     * @return ImageHandler
     */
    public static function startHandlerOperation(File $file, array $object)
    {
        $path = upload_path();

        $original = static::saveOriginal($file, $path);
        static::saveThumbnails($original, $path);
        $instance = static::createNewInstance($file);

        return static::attachToModel($instance, $object);
    }

    /**
     * @param File $file
     * @param $path
     * @return array
     */
    public static function saveOriginal(File $file, $path)
    {
        $file->move($path, $file->getClientOriginalName());

        $saveFile = $path.DIRECTORY_SEPARATOR.$file->getClientOriginalName();

        return [
            "path" => $saveFile,
            "name" => $file->getClientOriginalName()
        ];

    }


    /**
     * @param array $file
     * @param $path
     * @return bool
     */
    public static function saveThumbnails(array $file, $path)
    {
        foreach (config('thumbnails') as $key => $options) {

            $image = \Image::make($file['path']);

            if($options['crop'])
                $image->resizeCanvas($options['width'], $options['height']);
            else
                $image->resize($options['width'], $options['height']);

            $image->save($path.DIRECTORY_SEPARATOR.$options['width']."x".$options['height']."_".$file['name']);

        }

        return true;

    }

    /**
     * @param File $file
     * @return ImageHandler
     */
    private static function createNewInstance(File $file)
    {
        $image = new ImageHandler;
        $image->filename = $file->getClientOriginalName();

        return $image;
    }

    /**
     * $object[0] - imageable_id
     * $object[1] - imageable_type
     * @param ImageHandler $image
     * @param $object
     * @return ImageHandler
     */
    public static function attachToModel(ImageHandler $image, $object)
    {
        $image->imageable_id = $object[0];
        $image->imageable_type = $object[1];
        $image->save();

        return $image;

    }

}
