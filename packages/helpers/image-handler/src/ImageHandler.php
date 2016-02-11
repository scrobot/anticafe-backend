<?php

namespace Helpers\ImageHandler;

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

    public static $rules = [
        'file' => 'required|mimes:png,gif,jpeg,jpg,bmp'
    ];

    public static $messages = [
        'file.mimes' => '����������� ���� �� �������� �������� �����������',
        'file.required' => 'Image is required'
    ];

}
