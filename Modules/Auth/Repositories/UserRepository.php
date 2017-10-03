<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Entities\AuthUserShowLog;
use Modules\Auth\Entities\User;
use InfyOm\Generator\Common\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];
    
    protected $skipPresenter = true;
    
    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
    
    /**
     * Configure presenter
     */
    public function presenter()
    {
        return "Modules\\Auth\\Presenters\\UserPresenter";
    }
    
    public function create(array $attributes)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $attributes['password'] = bcrypt($attributes['password']);
        $model = parent::create($attributes);
        $this->skipPresenter($temporarySkipPresenter);
        
        $model = $this->updateRelations($model, $attributes);
        $model->save();
        
        return $this->parserResult($model);
    }
    
    public function update(array $attributes, $id)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        
        if (!empty($attributes['password'])) {
            if (trim($attributes['password'])) {
                $attributes['password'] = bcrypt($attributes['password']);
            } else {
                unset($attributes['password']);
            }
        }
        
        $model = parent::update($attributes, $id);
        $this->skipPresenter($temporarySkipPresenter);
        
        $model = $this->updateRelations($model, $attributes);
        $model->save();
        
        return $this->parserResult($model);
    }
    
    public function addFavoriteCompany($companyId, $userId)
    {
        $user = User::find($userId);
        try {
            $user->favorites()->attach($companyId);
            return $user->favorites;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function destroyFavoriteCompany($companyId, $userId)
    {
        $user = User::find($userId);
        if ($user->favorites()->detach($companyId)) {
            return true;
        } else {
            return false;
        }

    }

    public function addFavoriteArticle($articleId, $userId)
    {
        $user = User::find($userId);
        try {
            $user->articles()->attach($articleId);
            return $user->articles;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function destroyFavoriteArticle($articleId, $userId)
    {
        $user = User::find($userId);
        if ($user->articles()->detach($articleId)) {
            return true;
        } else {
            return false;
        }

    }
    
}
