<?php

namespace Modules\Catalog\Http\Requests\API;

use Modules\Catalog\Entities\CompanyRating;
use InfyOm\Generator\Request\APIRequest;

class CreateCompanyRatingAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'company_id' => 'required|exists:catalog_company,id',
            'total_rating' => 'required|integer|between:1,5',
        ];

        if (\Auth::check()) {
            $userId = \Auth::user()->id;

            $rules['company_id'] .= '|unique:catalog_company_rating,company_id,NULL,id,user_id,' . $userId;
        }

        return $rules;


    }
}