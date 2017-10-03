<?php

namespace Modules\News\Presenters;

use Modules\News\Transformers\SourceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ArticlesPresenter
 *
 * @package namespace Modules\News\Presenters;
 */
class SourcePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new SourceTransformer();
    }
}
