<?php

namespace Modules\Auth\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Auth\Entities\AuthUserShowLog;
use Modules\Catalog\Entities\CatalogCityCompanyPopular;
use Modules\Catalog\Entities\Company;
use Modules\News\Entities\Article;
use Modules\News\Entities\ArticlePopular;

class CollectDataShow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataShow:collect';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Counting viewing member entities';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->collectCompanyShow();
        $this->collectCompanyNews();
    }

    /**
     * counting viewed companies
     */
    public function collectCompanyShow()
    {
        $companiesViewedLog = AuthUserShowLog::where('entity', 'Modules\Catalog\Entities\Company')->get();
        foreach ($companiesViewedLog->groupBy('entity_id') as $companyLog) {
            $this->saveAllCountShowCompany($companyLog);
        }
    }
    
    private function saveAllCountShowCompany($companyLog)
    {
        if (is_object($companyLog)) {
            $company_id = $companyLog->first()->entity_id;
        } else {
            $company_id = $companyLog->entyti_id;
        }
        
        $companyViewed = CatalogCityCompanyPopular::where('company_id', $company_id)->first();
        
        if (is_null($companyViewed)) {
            $companyForCount = new CatalogCityCompanyPopular();
        } else {
            $companyForCount = $companyViewed;
        }

        $this->saveCountShowCompany($companyForCount, $companyLog, $company_id);
    }
    
    private function saveCountShowCompany($companyForCount, $company, $company_id)
    {
        $companyForCount->company_id = $company_id;
        $companyForCount->total = $company->count();
        $companyForCount->city_id = Company::where('id', $company_id)->first()->city_id;
        $companyForCount->last_date = Carbon::now();
        $companyForCount->save();
    }
    
    /**
     * counting viewed news
     */

    public function collectCompanyNews()
    {
        $newsViewedLog = AuthUserShowLog::where('entity', 'Modules\News\Entities\Article')->get();
        foreach ($newsViewedLog->groupBy('entity_id') as $newsLog) {
            $this->saveAllCountShowNews($newsLog);
        }
    }
    
    private function saveAllCountShowNews($newsLog)
    {
        if (is_object($newsLog)) {
            $article_id = $newsLog->first()->entity_id;
        } else {
            $article_id = $newsLog->entyti_id;
        }
        
        $articleViewed = ArticlePopular::where('article_id', $article_id)->first();
        
        if (is_null($articleViewed)) {
            $articleForCount = new ArticlePopular();
        } else {
            $articleForCount = $articleViewed;
        }
        
        $this->saveCountShowNews($articleForCount, $newsLog, $article_id);
    }
    
    private function saveCountShowNews($articleForCount, $article, $article_id)
    {

        $articleForCount->article_id = $article_id;
        $articleForCount->total = $article->count();
        $articleForCount->last_date = Carbon::now();
        $articleModel = Article::find($article_id);
        $articleForCount->publication_date = $articleModel->publication_date;
        $articleForCount->save();
    }
    
}
