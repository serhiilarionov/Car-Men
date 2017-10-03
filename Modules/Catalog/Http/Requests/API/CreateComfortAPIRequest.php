<?php

namespace Modules\Catalog\Http\Requests\API;

use Modules\Catalog\Entities\Comfort;
use InfyOm\Generator\Request\APIRequest;

class CreateComfortAPIRequest extends APIRequest
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
        return Comfort::$rules;
    }
}
