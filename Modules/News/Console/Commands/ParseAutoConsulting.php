<?php

namespace Modules\News\Console\Commands;

use ArandiLopez\Feed\Adapters\SimplePieItemAdapter;


class ParseAutoConsulting extends ParseRss
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:autoConsulting';
    
    /**
     * The url of rss.
     *
     * @var string
     */
    private $rssUrl = 'http://www.autoconsulting.com.ua/rss.html';
    

    /**
     * Create a new rss instance.
     *
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
        $this->runParse($this->rssUrl);
    }

    /**
     * Method for preparing information for article model
     * @param SimplePieItemAdapter $data
     * @return array
     */
    public function prepareDataNews(SimplePieItemAdapter $data)
    {
        $news = [];
        $news['title'] = $data->title;
        $news['source_id'] = 2;
        $news['source_link'] = $data->link ?: '';
        $news['publication_date'] = date("Y-m-d H:m:s", strtotime($data->date));
        $news['text'] = $data->description;
        $news['tags'] = json_encode(preg_split('/\//', $data->category->term));
        $news['image'] = $data->enclosure->link;
        return $news;
    }
}
