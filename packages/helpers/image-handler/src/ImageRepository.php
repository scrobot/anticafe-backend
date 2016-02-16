<?php

namespace Helpers\ImageHandler;


use Anticafe\Http\Models\ImageOption;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;
use Anticafe\Http\Models\User;
use Illuminate\Http\Request;

class ImageRepository
{

    private $session_tokens;

    public function __construct() {

        if(!\Session::has('session_tokens')){
            \Session::put('session_tokens', []);
        }

        $this->session_tokens = session('session_tokens');

    }

    /**
     * @param $form_data
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload( $form_data )
    {

        $validator = \Validator::make($form_data, ImageHandler::$rules, ImageHandler::$messages);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);

        }

        $photo = $form_data['file'];
        $path = $form_data['_folder'];

        $originalName = $photo->getClientOriginalName();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);

        $filename = sanitize($originalNameWithoutExt);
        $allowed_filename = $this->createUniqueFilename( $filename, $path );

        $filenameExt = $allowed_filename .'.jpg';

        $uploadSuccess1 = $this->original( $photo, $filenameExt, $path );

        $preferences = $this->icons( $photo, $filenameExt, $path );
        $preferences['preview'] = uploads().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$allowed_filename.'.jpg';

        if( !$uploadSuccess1 || !$preferences ) {

            return response()->json([
                'error' => true,
                'message' => 'Server error while uploading',
                'code' => 500
            ], 500);

        }

        $sessionImage = new ImageHandler();
        $sessionImage->filename      = $allowed_filename;
        $sessionImage->original_name = $originalName;
        $sessionImage->preferences = $preferences;
        $sessionImage->session_token = $form_data['_session'];
        $sessionImage->imageable_id = $form_data['_id'];
        $sessionImage->imageable_type = $form_data['_type'];
        $sessionImage->save();

        $this->sessionRecord($form_data['_session']);

        return response()->json([
            'error' => false,
            'code'  => 200
        ], 200);

    }

    /**
     * @param $filename
     * @param $path
     * @return string
     */
    private function createUniqueFilename( $filename, $path )
    {
        $full_size_dir = upload_path() . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
        $full_image_path = $full_size_dir . $filename . '.jpg';

        if ( \File::exists( $full_image_path ) )
        {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken;
        }

        return $filename;
    }

    /**
     * Optimize Original Image
     */
    private function original( $photo, $filename, $path )
    {
        $manager = new ImageManager();
        $image = $manager->make( $photo )->encode('jpg')->save(upload_path() . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $filename );

        return $image;
    }

    /**
     * Create Icons From Original
     */
    private function icons( $photo, $filename, $path )
    {
        $thumbs_config = ImageOption::all();
        $properties = [];


        foreach ($thumbs_config as $option) {
            $dir = public_path() . '/images/anticafes/' . $path . DIRECTORY_SEPARATOR . $option->name;

            if (!is_dir($dir)) {
                mkdir($dir);
            }

            $manager = new ImageManager();

            $manager->make( $photo )->encode('jpg')->fit($option->width, $option->height, null, $option->anchor)->save($dir . DIRECTORY_SEPARATOR . $filename );

            $properties[$option->name] = '/images/anticafes/' . $path . DIRECTORY_SEPARATOR . $option->name . DIRECTORY_SEPARATOR . $filename;
        }

        return $properties;
    }

    /**
     * Delete Image From Session folder, based on original filename
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($data)
    {
        $id = explode('/', $data['id']);
        $sessionImage = ImageHandler::where('original_name', 'like', $id)->first();

        /*TODO: Разрбрать этот костыль и оптимизировать все в один запрос*/
        if(is_null($sessionImage))
            $sessionImage = ImageHandler::where('filename', explode('.', $id[count($id)-1])[0])->first();

        if(empty($sessionImage)){
            return response()->json([
                'error' => true,
                'code'  => 400
            ], 400);

        }

        $this->deleteImage($sessionImage, $data['_folder']);

        $sessionImage->delete();

        $this->sessionDelete($data['_session']);

        return response()->json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    /**
     * @param $session_token
     */
    private function sessionRecord($session_token)
    {
        if(!in_array($session_token, $this->session_tokens)) {
            \Session::push('session_tokens', $session_token);
        }

    }

    /**
     * @param $session_token
     */
    private function sessionDelete($session_token)
    {
        $images = ImageHandler::where('session_token', $session_token)->get();

        if(count($images) == 0) {
            if(($key = array_search($session_token, $this->session_tokens)) !== false) {
                unset($this->session_tokens[$key]);
            }
            \Session::put('session_tokens', $this->session_tokens);
        }
    }

    /**
     * @param ImageHandler $image
     * @param $path
     */
    private function deleteImage(ImageHandler $image, $path)
    {
        $thumbs_config = ImageOption::all();
        $full_size_path = upload_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR;
        $this->fileDelete($full_size_path.$image->filename . '.jpg');

        foreach ($thumbs_config as $options) {
            $full_file_path = $full_size_path . $options->name . DIRECTORY_SEPARATOR . $image->filename . '.jpg';
            $this->fileDelete($full_file_path);
        }

    }

    /**
     * @param $file
     */
    private function fileDelete($file)
    {
        if ( \File::exists( $file) )
        {
            \File::delete( $file );
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setPreview($request)
    {
        $sessionImage = ImageHandler::where('original_name', 'like', $request['id'])->where('session_token', $request['_session'])->first();

        if(empty($sessionImage))
        {
            return response()->json([
                'error' => true,
                'code'  => 400
            ], 400);

        }

        // reset preview
        ImageHandler::where('session_token', $request['_session'])->update([
            'preview' => 0
        ]);

        $sessionImage->update([
            'preview' => 1
        ]);

        return response()->json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    /**
     * @param Model $model
     * @param $session_token
     */
    public static function saveFromSession(Model $model, $session_token)
    {
        ImageHandler::where('session_token', $session_token)->update([
            'imageable_id' => $model->id,
            'imageable_type' => get_class($model)
        ]);

        $session_tokens = session('session_tokens') ? session('session_tokens') : [];

        if(($key = array_search($session_token, $session_tokens)) !== false) {
            unset($session_tokens[$key]);
        }

        \Session::put('session_tokens', $session_tokens);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param $session_token
     */
    public function thumbnails(Request $request)
    {
        $images = ImageHandler::where('imageable_id', $request->input('_id'))->where('imageable_type', $request->input('_type'))->get();
        $response = [];

        if(count($images)) {
            foreach ($images as $image) {
                $response[] = [
                    'name' => $image->preferences['100x100'],
                    'size' => filesize(public_path().$image->preferences['preview'])
                ];
            }
        }

        return response()->json($response);
    }

}