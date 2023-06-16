<?php

class Changelog extends MX_Controller
{
    private $changelog_days;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('changelog_model');
        $this->load->config('changelog');

        requirePermission("view");
    }

    public function index()
    {
        clientLang("changes_made_on", "changelog");

        $this->template->setTitle(lang("changelog_title", "changelog"));

        $changelog_items = $this->changelog_model->getChangelog($this->config->item('changelog_limit'));

        if ($changelog_items) {
            // Sort by time, this will move every single item to an array with as key the time.
            $changelog_items = $this->sortByTime($changelog_items);
        }

        $data = array(
            "changes" => $changelog_items,
            "url" => $this->template->page_url,
            "categories" => $this->changelog_model->getCategories(),
            'attributes' => array("id" => "category_form", "style" => "display:none;")
        );

        $content =  $this->template->loadPage("changelog.tpl", $data);

        $this->template->box(lang("changelog_title", "changelog"), $content, true, "modules/changelog/css/changelog.css", "modules/changelog/js/changelog.js");
    }

    /**
     * Sort by time and get the new array
     *
     * @param  $changelog_items
     * @return array
     */
    public function sortByTime($changelog_items)
    {
        $new_array = array();

        foreach ($changelog_items as $item) {
            // If we dont got the time yet add it to the new array
            if (!array_key_exists(date("Y/m/d", $item['time']), $new_array)) {
                //Assign an array to that key
                $new_array[date("Y/m/d", $item['time'])] = array();
            }

            // Do the same but then for the typeName
            if (!array_key_exists($item['typeName'], $new_array[date("Y/m/d", $item['time'])])) {
                //Assign an array to that key
                $new_array[date("Y/m/d", $item['time'])][$item['typeName']] = array();
            }

            array_push($new_array[date("Y/m/d", $item['time'])][$item['typeName']], $item);
        }

        return $new_array;
    }

    /**
     * Add a category
     */
    public function addCategory()
    {
        // Check for the permission
        requirePermission("canAddCategory");

        $name = $this->input->post('category');

        $id = $this->changelog_model->addCategory($name);

        $this->logger->createLog("admin", "add", "Created category", ['Name' => $name]);

        $this->plugins->onAddCategory($id, $name);

        redirect('changelog');
    }

    /**
     * Add a change with the given change and category in post.
     */
    public function addChange()
    {
        // Check for the permission
        requirePermission("canAddChange");

        $change = $this->input->post('change');
        $category = $this->input->post('category');

        if (empty($category) || empty($change)) {
            redirect('changelog');
        }

        $id = $this->changelog_model->addChange($change, $category);

        $this->logger->createLog("admin", "add", "Created change", ['ID' => $id]);

        $this->plugins->onAddChange($id, $change, $category);

        die($id . "");

        $this->index();
    }

    /**
     * Remove change from the changelog with the given id
     *
     * @param bool $id
     */
    public function remove($id = false)
    {
        // Check for the permission
        requirePermission("canRemoveChange");

        if (!($id && is_numeric($id))) {
            redirect('changelog');
        }

        $this->changelog_model->deleteChange($id);

        $this->logger->createLog("admin", "delete", "Deleted change", ['ID' => $id]);

        $this->plugins->onDeleteChange($id);

        $this->index();
    }
}
