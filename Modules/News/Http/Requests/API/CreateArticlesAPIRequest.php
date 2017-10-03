<?php

namespace Modules\News\Http\Requests\API;

use Modules\News\Entities\Articles;
use InfyOm\Generator\Request\APIRequest;

class CreateArticlesAPIRequest extends APIRequest
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
        return Articles::$rules;
    }
}
