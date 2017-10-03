<?php

namespace Modules\Catalog\Http\Requests\API;

use Modules\Catalog\Entities\CompanyRatingCategory;
use InfyOm\Generator\Request\APIRequest;

class UpdateCompanyRatingCategoryAPIRequest extends APIRequest
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
        return CompanyRatingCategory::$rules;
    }
}
