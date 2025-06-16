<?php

use MX\MX_Controller;

/**
 * Store Controller Class
 * @property store_model $store_model store_model Class
 */
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
        $data = [
            'url' => $this->template->page_url,
            'image_path' => $this->template->image_path,
            'vp' => $this->user->getVp(),
            'dp' => $this->user->getDp(),
            'data' => $this->getData(),
            'minimize' => $this->config->item('minimize_groups_by_default')
        ];

        // Load the content
        $content = $this->template->loadPage("store.tpl", $data);

        // Load the topsite page and format the page contents
        $pageData = [
            "module" => "default",
            "headline" => breadcrumb([
                            "ucp" => lang("ucp"),
                            "store" => lang("item_store", "store")
            ]),
            "content" => $content
        ];

        $page = $this->template->loadPage("page.tpl", $pageData);

        // Output the content
        $this->template->view($page, "modules/store/css/store.css", "modules/store/js/store.js");
    }

    /**
     * Get all realms, item groups and items and format them nicely in an array
     *
     * @return Array
     */
    private function getData(): array
    {
        $cache = $this->cache->get("store_items");

        if ($cache !== false) {
            return $cache;
        } else {
            $data = [];

            foreach ($this->realms->getRealms() as $realm) {
                // Load all items that belong to this realm
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
     * Put items in their groups and put unassigned items in a separate list
     *
     * @param array|false $items
     * @return Array
     */
    private function formatItems(array|false $items): array
    {
        $data = [
            'groups' => [],
            'items' => []
        ];

        if (!$items)
            return $data;

        $allGroups = $this->store_model->getStoreGroups();
        $groupsCache = [];

        foreach ($allGroups as $group) {
            $groupsCache[$group['id']] = $group;
        }

        // Loop through all items
        foreach ($items as $item) {
            if (empty($item['group']) || !isset($groupsCache[$item['group']])) {
                $data['items'][] = $item;
                continue;
            }

            if (!isset($data['groups'][$item['group']])) {
                $group = $groupsCache[$item['group']];
                $data['groups'][$item['group']] = [
                    'title' => $group['title'],
                    'icon' => $group['icon'],
                    'id' => $group['id'],
                    'items' => []
                ];
            }

            $data['groups'][$item['group']]['items'][] = $item;
        }

        return $data;
    }
}
