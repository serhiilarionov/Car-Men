<?php

namespace Modules\Catalog\Http\Requests\API;

use Modules\Catalog\Entities\CompanyRating;
use InfyOm\Generator\Request\APIRequest;

class UpdateCompanyRatingAPIRequest extends APIRequest
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
        return CompanyRating::$rules;
    }
}