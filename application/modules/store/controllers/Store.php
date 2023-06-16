<?php

class Store extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        $this->user->userArea();

        $this->load->model("store_model");

        $this->load->config('store');

        requirePermission("view");
    }

    public function index()
    {
        requirePermission("view");

        clientLang("cant_afford", "store");
        clientLang("hide", "store");
        clientLang("show", "store");
        clientLang("loading", "store");
        clientLang("want_to_buy", "store");
        clientLang("yes", "store");
        clientLang("checkout", "store");
        clientLang("vp", "store");
        clientLang("dp", "store");

        // Gather the template data
        $data = array(
            'url' => $this->template->page_url,
            'image_path' => $this->template->image_path,
            'vp' => $this->user->getVp(),
            'dp' => $this->user->getDp(),
            'data' => $this->getData(),
            'minimize' => $this->config->item('minimize_groups_by_default')
        );

        // Load the content
        $content = $this->template->loadPage("store.tpl", $data);

        // Put the content in a box
        $page = $this->template->box("<span style='cursor:pointer;' onClick='window.location=\"" . $this->template->page_url . "ucp\"'>" . lang("ucp") . "</span> &rarr; " . lang("item_store", "store"), $content);

        // Output the content
        $this->template->view($page, "modules/store/css/store.css", "modules/store/js/store.js");
    }

    /**
     * Get all realms, item groups and items and format them nicely in an array
     *
     * @return Array
     */
    private function getData()
    {
        $cache = $this->cache->get("store_items");

        if ($cache !== false) {
            return $cache;
        } else {
            $data = array();

            foreach ($this->realms->getRealms() as $realm) {
                // Load all items that belongs to this realm
                $items = $this->store_model->getItems($realm->getId());

                // Assign the realm name
                $data[$realm->getId()]['name'] = $realm->getName();

                // Assign and format the items by their groups
                $data[$realm->getId()]['items'] = $this->formatItems($items);
            }

            $this->cache->save("store_items", $data, 60 * 60);

            return $data;
        }
    }

    /**
     * Put items in their groups and put un-assigned items in a separate list
     *
     * @param  Array $items
     * @return Array
     */
    private function formatItems($items)
    {
        if ($items != false) {
            $data = array(
                'groups' => array(), // Holds group titles and their items
                'items' => array() // Holds items without a group
            );

            $currentGroup = null;

            // Loop through all items
            foreach ($items as $item) {
                if (empty($item['group'])) {
                    array_push($data['items'], $item);
                } else {
                    if ($currentGroup != $item['group']) {
                        $currentGroup = $item['group'];

                        // Assign the name to a group
                        $data['groups'][$item['group']]['title'] = $this->store_model->getGroupTitle($item['group']);
                        $data['groups'][$item['group']]['id'] = $this->store_model->getGroupId($data['groups'][$item['group']]['title']);

                        // Create the item array
                        $data['groups'][$item['group']]['items'] = array();
                    }

                    array_push($data['groups'][$item['group']]['items'], $item);
                }
            }

            return $data;
        }
    }
}
