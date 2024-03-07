<?php defined('BASEPATH') OR exit('No direct script access allowed');

use MX\MX_Controller;

/**
 * Latest_article Controller Class
 * @property latest_article_model $latest_article_model latest_article_model Class
 */
class Latest_article extends MX_Controller
{
    # Directory separator shortcut
    const DS = DIRECTORY_SEPARATOR;

    # Metadata properties
    private static $moduleUrl;
    private static $modulePath;
    private static $moduleName;

    # Data properties
    private static $News;

    public function __construct()
    {
        // Call `MX_Controller` construct
        parent::__construct();

        // Get module name
        self::$moduleName = basename(str_replace('controllers', '', __DIR__));

        // Get module url
        self::$moduleUrl = rtrim(base_url(), '/') . '/' . basename(APPPATH) . '/modules/' . self::$moduleName . '/';

        // Get module path
        self::$modulePath = rtrim(str_replace(['\\', '/'], self::DS, realpath(APPPATH)), self::DS) . self::DS . 'modules' . self::DS . self::$moduleName . self::DS;

        // Load models
        $this->load->model(self::$moduleName . '/latest_article_model');

        // Get Latest article
        self::$News = $this->getNews($this->latest_article_model->getArticles(false,5));
    }

    public function view()
    {
        // Prepare data
        $data = [
            # Metadata
            'module'     => self::$moduleName,
            'moduleUrl'  => self::$moduleUrl,
            'modulePath' => self::$modulePath,
            'news'       => self::$News ,
            'url'        => $this->template->page_url
        ];

        // Render output
        return $this->template->loadPage('latest.tpl', $data);
    }
    
     private function getNews($articles)
     {
         if ($articles) {
             foreach ($articles as $key => $value) {
                 $articles[$key]['headline'] = langColumn($value['headline']);

                 if (strlen($value['headline']) > 20) {
                     $articles[$key]['headline'] = (strlen(mb_substr($articles[$key]['headline'], 0, 40)) < 40) ? mb_substr($articles[$key]['headline'], 0, 40) : mb_substr($articles[$key]['headline'], 0, 40) . ' ...';
                 }

                 $articles[$key]['date'] = 'Posted by ' . $this->user->getNickname($value['author_id']) . ' on ' . date("Y/m/d", $value['timestamp']);

                 $articles[$key]['id'] = $value['id'];
             }
         }

        return $articles;
     } 
}
