<?php

use CodeIgniter\Events\Events;
use MX\MX_Controller;

/**
 * Admin News Controller Class
 * @property news_model $news_model news_model Class
 */
class Admin extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('news_model');

        //Load upload library
        $this->load->library('upload');

        parent::__construct();

        requirePermission("canViewAdmin");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("News");

        $articles = $this->news_model->getArticles(true);

        if ($articles) {
            foreach ($articles as $key => $value) {
                $articles[$key]['headline'] = langColumn($value['headline']);

                if (strlen($value['headline']) > 20) {
                    $articles[$key]['headline'] = mb_substr($articles[$key]['headline'], 0, 20) . '...';
                }

                $articles[$key]['nickname'] = $this->user->getNickname($value['author_id']);
            }
        }

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'news' => $articles,
            'lang' => $this->language->getLanguageAbbreviation()
        );

        // Load my view
        $output = $this->template->loadPage("admin.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('News articles', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/news/js/admin.js");
    }

    public function new()
    {
        requirePermission("canAddArticle");

        // Change the title
        $this->administrator->setTitle('News - New');

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            "defaultLanguage" => $this->config->item('language'),
            "languages" => $this->language->getAllLanguages(),
            "abbreviationLanguage" => $this->language->getAbbreviationByLanguage($this->language->getLanguage()),
        );

        // Load my view
        $output = $this->template->loadPage("admin_new.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Create article', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/news/js/admin.js");
    }

    /**
     * Edit a news post with the given id.
     *
     * @param bool $id
     */
    public function edit($id = false)
    {
        requirePermission("canEditArticle");

        if (!$id || !is_numeric($id)) {
            header('Location: ' . pageURL . 'news/admin');
            die();
        }

        $article = $this->news_model->getArticle($id);

        $title = langColumn($article['headline']);

        $article['headline'] = json_decode($article['headline'], true);
        $article['content'] = json_decode($article['content'], true);

        if (!$article) {
            header('Location: ' . pageURL . 'news/admin');
            die();
        }

        // Change the title
        $this->administrator->setTitle($title);

        // Prepare my data
        $data = [
            'url' => $this->template->page_url,
            "defaultLanguage" => $this->config->item('language'),
            "languages" => $this->language->getAllLanguages(),
            "abbreviationLanguage" => $this->language->getAbbreviationByLanguage($this->language->getLanguage()),
            'article' => $article
        ];

        // Load my view
        $output = $this->template->loadPage("admin_edit.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'news/admin">News articles</a> &rarr; ' . $title, $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/news/js/admin.js");
    }

    public function delete($id = false)
    {
        requirePermission("canRemoveArticle");

        if (!$id) {
            die();
        }

        $news = $this->news_model->getArticle($id);
        if ($news["type"] == 1) {
            $type_contents = json_decode($news["type_content"], true);
            //Delete old files
            foreach ($type_contents as $file) {
                if (file_exists(FCPATH . "/writable/uploads/news/" . $file)) {
                    unlink(FCPATH . "/writable/uploads/news/" . $file);
                }
            }
        }
        $this->cache->delete('news_*.cache');
        $this->news_model->delete($id);

        // Add log
        $this->dblogger->createLog("admin", "delete", "Deleted news", ['news' => $id]);

        Events::trigger('onDeleteNews', $id);
    }

    public function create($id = false)
    {
        requirePermission("canAddArticle");

        $type = $this->input->post('type');
        $comments = $this->input->post('comments');
        $headline = $this->input->post('headline');
        $content = $this->input->post('content', false);

        if (strlen(langColumn($headline)) > 70 || empty(langColumn($headline))) {
            die("The headline for the default language must be between 1-70 characters long");
        }

        if (empty($content)) {
            die("Content for the default language can't be empty");
        }

        if (in_array($comments, array("1", "yes", "true"))) {
            $comments = "0";
        } else {
            $comments = "-1";
        }

        switch ($type) {
            case '0':
                $type_content = "";
                break;
            case '1':
                $fileNames = $this->input->post('fileNames');
                $type_content = array();

                if (!isset($fileNames)) {
                    if (!isset($_FILES['type_image'])) {
                        die('Please select at least 1 image');
                    }
                }

                if (isset($_FILES['type_image'])) {
                    $countfiles = count($_FILES['type_image']["name"]);

                    if ($countfiles <= 0) {
                        die('Please select at least 1 image');
                    }

                    for ($i = 0; $i < $countfiles; $i++) {
                        if (!empty($_FILES['type_image']["name"][$i])) {
                            // Define new $_FILES array - $_FILES['file']
                            $_FILES['file']['name'] = time() . "_" . $_FILES['type_image']['name'][$i];
                            $_FILES['file']['type'] = $_FILES['type_image']['type'][$i];
                            $_FILES['file']['tmp_name'] = $_FILES['type_image']['tmp_name'][$i];
                            $_FILES['file']['error'] = $_FILES['type_image']['error'][$i];
                            $_FILES['file']['size'] = $_FILES['type_image']['size'][$i];

                            // Set preference
                            $config['upload_path'] = FCPATH . '/writable/uploads/news';
                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                            $config['overwrite'] = true;
                            $config['max_size'] = '1000000';
                            $config['max_width']  = '3024';
                            $config['max_height']  = '2000';
                            $config['file_name'] = $_FILES['file']['name'];

                            if (!is_dir($config['upload_path'])) {
                                @mkdir($config['upload_path']);
                            }

                            $this->upload->initialize($config);

                            // File upload
                            if (!$this->upload->do_upload('file')) {
                                die($this->upload->display_errors());
                            } else {
                                $data = $this->upload->data();
                                $type_content[] = $data['file_name'];
                            }
                        }
                    }
                }

                break;
            case '2':
                if ($this->input->post('type_video')) {
                    $type_content = $this->input->post('type_video');
                } else {
                    die('Please insert video link');
                }
                break;
        }

        $news = $this->news_model->getArticle($id);

        if ($id) {
            if ($type == 1) {
                $type_contents = json_decode($news["type_content"], true);
                $fileNames = $this->input->post('fileNames');
                if (strpos($fileNames, ",") !== false) {
                    $fileNames = explode(",", $fileNames);
                    for ($i = 0; $i < count(array($type_contents)); $i++) {
                        foreach ($fileNames as $name) {
                            if (isset($type_contents[$i])) {
                                if ($type_contents[$i] == $name) {
                                    array_splice($type_contents, $i, 1);
                                    $type_content[] = $name;
                                }
                            }
                        }
                    }
                } else {
                    for ($i = 0; $i < count(array($type_contents)); $i++) {
                        if (isset($type_contents[$i])) {
                            if ($type_contents[$i] == $fileNames) {
                                array_splice($type_contents, $i, 1);
                                $type_content[] = $fileNames;
                            }
                        }
                    }
                }

                //Delete Old Files
                if (is_countable($type_contents) && count($type_contents) > 0) {
                    foreach ($type_contents as $file) {
                        if (file_exists(FCPATH . "/writable/uploads/news/" . $file)) {
                            unlink(FCPATH . "/writable/uploads/news/" . $file);
                        }
                    }
                }

                //die(print_r($type_contents));
                $type_content = json_encode($type_content);
            }

            $this->news_model->update($id, $type, $type_content, $comments, $headline, $content);

            // Add log
            $this->dblogger->createLog("admin", "edit", "Edited a news", ['news' => $headline]);

            Events::trigger('onUpdateNews', $id, $type, $type_content, $comments, $headline, $content);
        } else {
            if ($type == 1) {
                $type_content = json_encode($type_content);
            }

            $this->news_model->create($type, $type_content, $comments, $headline, $content);

            // Add log
            $this->dblogger->createLog("admin", "add", "Created a news", ['news' => $headline]);

            Events::trigger('onCreateNews', $type, $type_content, $comments, $headline, $content);
        }

        $this->cache->delete('news_*.cache');

        die("yes");
    }
}
