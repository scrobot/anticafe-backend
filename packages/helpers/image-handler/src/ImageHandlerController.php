<?php

namespace Helpers\ImageHandler;

use Anticafe\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageHandlerController extends Controller
{

    protected $image;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->image = $imageRepository;
    }

    public function postUpload(Request $request)
    {
        return $this->image->upload($request->all());
    }

    public function postDelete(Request $request)
    {
        $data = $request->all();

        if(!$data) return 0;

        return $this->image->delete($data);
    }

    public function postPreview(Request $request)
    {
        $data = $request->all();

        if(!$data) return 0;

        return $this->image->setPreview($data);
    }

    public function getThumbnails(Request $request)
    {
        return $this->image->thumbnails($request->input('_session'));
    }
}
