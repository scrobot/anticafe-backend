<?php

namespace Anticafe\Http\Services;

use Anticafe\Http\Models\ImageOption;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;

class ImageProcessor
{

    private $file;
    private $dirs;
    private $type;
    private $anticafes_dir;
    private $file_original_name;
    private $filename;

    /**
     * ImageProcessor constructor.
     * @param $file
     */
    public function __construct(File $file, $type)
    {
        $this->file = (new ImageManager())->make($file)->encode("jpg");
        $this->anticafes_dir = public_path() . '/images/anticafes/';
        $this->dirs = [
            "covers" => $this->anticafes_dir . 'covers/',
            "logos" => $this->anticafes_dir . 'logos/',
            "gallery" => $this->anticafes_dir . 'logos/'
        ];
        $this->type = $type;
        $this->file_original_name = md5($file->getClientOriginalName());
        $this->filename = $this->file_original_name.'.jpg';
    }

    public function start()
    {
        $this->createDirsIfNotExsists();
        $original = $this->createOriginal();
        $this->createThumbs();

        return $original;
    }

    private function createDirsIfNotExsists()
    {
        foreach (ImageOption::all() as $option) {
            foreach ($this->dirs as $dir) {
                if (!is_dir($dir . $option->name)) {
                    mkdir($dir . $option->name);
                }
            }
        }

    }

    private function createOriginal()
    {
        $file = $this->file
            ->encode('jpg', 75);
        if($this->type == "covers") {
            $file->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $file->save($this->dirs[$this->type].$this->filename);
        return $this->filename;
    }

    private function createThumbs()
    {
        foreach (ImageOption::all() as $option) {
            $this->file
                ->encode('jpg', 75)
                ->fit($option->width, $option->height, null, $option->anchor)
                /*->resizeCanvas($option->width, $option->height, $option->anchor, $option->relative ? true : false, $option->bgcolor)*/
                ->save($this->dirs[$this->type]."/{$option->name}/".$option->name."_".$this->filename);
        }
    }

}

