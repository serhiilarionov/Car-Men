<?php

namespace Modules\Auth\Presenters;

use Modules\Auth\Transformers\DeviceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DevicePresenter
 *
 * @package namespace Modules\Auth\Presenters;
 */
class DevicePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DeviceTransformer();
    }
}
