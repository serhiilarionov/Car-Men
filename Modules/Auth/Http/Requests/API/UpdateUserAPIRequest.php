<?php

namespace Modules\Auth\Http\Requests\API;

use Modules\Auth\Entities\User;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserAPIRequest extends APIRequest
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
            'name' => 'required|max:255|unique:auth_users',
            'email' => 'email|max:255|unique:auth_users',
        ];
    }
}
