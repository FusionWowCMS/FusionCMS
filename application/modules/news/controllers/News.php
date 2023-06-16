<?php

class News extends MX_Controller
{
    private $news_articles = array();
    private $startIndex = 0;

    public function __construct()
    {
        // Call the constructor of MX_Controller
        parent::__construct();

        $this->load->config('news');
        $this->load->library('pagination');
        $this->load->model('news_model');
        $this->load->model('comments_model');
    }

    public function sortByDate($a, $b)
    {
        return $b['timestamp'] - $a['timestamp'];
    }

    /**
     * Default to page 1
     */
    public function index()
    {
        requirePermission("view");

        $this->getNews();

        usort($this->news_articles, array($this, "sortByDate"));

        // Show the page
        $this->displayPage();
    }

    public function view($id = null)
    {
        requirePermission("canViewSpecificArticle");

        if (!$id || !is_numeric($id)) {
            header('Location: ' . pageURL . 'news');
        }

        // if it's not an int or the article doesn't exist, load the index page.
        if (!$this->news_model->articleExists($id)) {
            $this->index();
            return;
        }

        // Get the cache
        $cache = $this->cache->get("news_id" . $id . "_" . getLang());

        // Check if cache is valid
        if ($cache !== false) {
            $this->template->view($cache, "modules/news/css/news.css", "modules/news/js/ajax.js");
        } else {
            // Get the article passed
            $this->news_articles = $this->template->format(array($this->news_model->getArticle($id)));

            $LangAbbr = $this->language->getLanguageAbbreviation();
            $DefaultLangAbbr = $this->language->getAbbreviationByLanguage($this->language->getDefaultLanguage());

            // For each key we need to add the special values that we want to print
            foreach ($this->news_articles as $key => $article) {
                if (empty($article['headline_' . $LangAbbr . ''])) {
                    $this->news_articles[$key]['headline'] = $article['headline_' . $DefaultLangAbbr . ''];
                } else {
                    $this->news_articles[$key]['headline'] = $article['headline_' . $LangAbbr . ''];
                }

                if (empty($article['content_' . $LangAbbr . ''])) {
                    $this->news_articles[$key]['content'] = langColumn($article['content_' . $DefaultLangAbbr . '']);
                } else {
                    $this->news_articles[$key]['content'] = langColumn($article['content_' . $LangAbbr . '']);
                }
                $this->news_articles[$key]['date'] = date("Y/m/d", $article['timestamp']);
                $this->news_articles[$key]['author'] = $this->user->getNickname($article['author_id']);
                $this->news_articles[$key]['link'] = ($article['comments'] == -1) ? '' : "href='javascript:void(0)' onClick='Ajax.showComments(" . $article['id'] . ")'";
                $this->news_articles[$key]['comments_id'] = "id='comments_" . $article['id'] . "'";
                $this->news_articles[$key]['comments_button_id'] = "id='comments_button_" . $article['id'] . "'";
                $this->news_articles[$key]['tags'] = $this->news_model->getTags($id);
                $this->news_articles[$key]['type_content'] = ($article['type'] == 2) ? $article['type_content'] : json_decode($article['type_content'], true);
            }

            $content = $this->template->loadPage("articles.tpl", array("articles" => $this->news_articles, 'url' => $this->template->page_url, "pagination" => ''));
            $content .= $this->template->loadPage("expand_comments.tpl", array("article" => $this->news_articles[0], 'url' => $this->template->page_url));
            $this->cache->save("news_id" . $id . "_" . getLang(), $content);

            // Load the template and pass the page content
            $this->template->view($content, "modules/news/css/news.css", "modules/news/js/ajax.js");
        }
    }

    private function displayPage()
    {
        // Get the cache
        $cache = $this->cache->get("news_" . $this->startIndex . "_" . getLang());

        // Check if cache is valid
        if ($cache !== false) {
            $this->template->view($cache, "modules/news/css/news.css", "modules/news/js/ajax.js");
        } else {
            $content = $this->template->loadPage(
                "articles.tpl",
                array(
                "articles" => $this->news_articles,
                'url' => $this->template->page_url,
                "pagination" => $this->pagination->create_links(),
                'single' => false)
            );

            $this->cache->save("news_" . $this->startIndex . "_" . getLang(), $content);

            // Load the template and pass the page content
            $this->template->view($content, "modules/news/css/news.css", "modules/news/js/ajax.js");
        }
    }

    private function getNews()
    {
        // Init pagination
        $config = $this->initPagination();

        // Decide our starting index of the news
        $this->startIndex = $this->uri->segment($config['uri_segment']);

        if (empty($this->startIndex)) {
            $this->startIndex = 0;
        }

        // Get the articles with the lower and upper limit decided by our pagination.
        $this->news_articles = $this->news_model->getArticles((int)$this->startIndex, ((int)$this->startIndex + $config['per_page']));

        $LangAbbr = $this->language->getLanguageAbbreviation();
        $DefaultLangAbbr = $this->language->getAbbreviationByLanguage($this->language->getDefaultLanguage());

        // For each key we need to add the special values that we want to print
        foreach ($this->news_articles as $key => $article) {
            if (empty($article['headline_' . $LangAbbr . ''])) {
                $this->news_articles[$key]['headline'] = $article['headline_' . $DefaultLangAbbr . ''];
            } else {
                $this->news_articles[$key]['headline'] = $article['headline_' . $LangAbbr . ''];
            }

            if (empty($article['content_' . $LangAbbr . ''])) {
                $this->news_articles[$key]['content'] = character_limiter(langColumn($article['content_' . $DefaultLangAbbr . '']), 650);
            } else {
                $this->news_articles[$key]['content'] = character_limiter(langColumn($article['content_' . $LangAbbr . '']), 650);
            }
            $this->news_articles[$key]['date'] = date("Y/m/d", $article['timestamp']);
            $this->news_articles[$key]['author'] = ($article['author_id'] == 0) ? lang("system", "news") : $this->user->getNickname($article['author_id']) ;
            $this->news_articles[$key]['link'] = ($article['comments'] == -1) ? '' : "href='javascript:void(0)' onClick='Ajax.showComments(" . $article['id'] . ")'";
            $this->news_articles[$key]['comments_id'] = "id='comments_" . $article['id'] . "'";
            $this->news_articles[$key]['comments_button_id'] = "id='comments_button_" . $article['id'] . "'";
            $this->news_articles[$key]['tags'] = $this->news_model->getTags($article['id']);
            $this->news_articles[$key]['type_content'] = ($article['type'] == 2) ? $article['type_content'] : json_decode($article['type_content'], true);
        }
    }

    private function initPagination()
    {
        // Basic configs
        $config['uri_segment'] = '2';
        $config['base_url'] = base_url() . '/news';
        $config['total_rows'] = $this->news_model->countArticles();
        $config['per_page'] = $this->config->item('news_limit');

        $config['full_tag_open'] = '<ul class="pagination float-end">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link"><a href="#">';
        $config['cur_tag_close'] = '</a></span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        // DISABLE THE PAGE NUMBERS
        $config['display_pages'] = true;


        $this->pagination->initialize($config);

        return $config;
    }
}
