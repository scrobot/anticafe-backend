<?php

namespace Pinerp\ImageHandler;


use Carbon\Carbon;
use Stringy\StaticStringy;
use Symfony\Component\HttpFoundation\File\File;
use Pincommon\Layout\BaseController as Controller;
use Illuminate\Http\Request;

class ImageHandlerController extends Controller
{
    /*
     * TODO: придумать алгоритм наименования файлов, на случай совпадения имен. Возвращать имя файла на клиент.
     * */

    public function postStore(Request $request)
    {
        $image = ImageHandler::startHandlerOperation($request->file('file'), [$request->input('imageable_id'), $request->input('imageable_type')]);

        return response()->json(uploads().$image->filename);
    }
    
    public function postRemoveImage(Request $request)
    {
        ImageHandler::where('filename', $request->input('filename'))->delete();

        return response()->json('removed');
    }

    public function getDeleteImage($id)
    {
        ImageHandler::destroy($id);

        return back()->withMsg('layout::common.msg.delete');
    }


}
