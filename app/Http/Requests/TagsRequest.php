<?php

namespace Anticafe\Http\Requests;

use Anticafe\Http\Requests\Request;

class TagsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "icon" => "sometimes|required|image|image_aspect:1|mimes:png",
//            "icon" => "sometimes|required|image|mimes:png",
            "name" => "required"
        ];
    }
}
