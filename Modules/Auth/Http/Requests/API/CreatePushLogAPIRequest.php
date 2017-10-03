<?php

namespace Modules\Auth\Http\Requests\API;

use Modules\Auth\Entities\PushLog;
use InfyOm\Generator\Request\APIRequest;

class CreatePushLogAPIRequest extends APIRequest
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
        return PushLog::$rules;
    }
}
