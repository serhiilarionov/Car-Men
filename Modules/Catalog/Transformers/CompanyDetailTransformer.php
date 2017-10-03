<?php namespace Modules\Catalog\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Catalog\Entities\CompanyDetail;

/**
 * Class CompanyDetailTransformer
 * @package namespace Modules\Catalog\Transformers;
 */
class CompanyDetailTransformer extends TransformerAbstract
{

    /**
     * Transform the CompanyDetail entity
     * @param CompanyDetail $model
     *
     * @return array
     */
    public function transform(CompanyDetail $model)
    {
        $result = [
            'phones' => $model->phones,
            'email' => $model->email,
            'website' => $model->website,
            'work_time' => $model->work_time,
            'desc' => $model->desc,
            'payment' => $model->payment,
            'closing_time' => null,
        ];

        $today = date('w') - 1;
        if($today < 0) {
            $today = 6;
        }

        if(is_array($model->work_time) && isset($model->work_time[$today])) {
            $result['closing_time'] = $model->work_time[$today]->timeTill;
        }

        return $result;
    }
}
