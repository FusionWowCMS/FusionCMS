<?php

class Slider extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('slider_model');

        parent::__construct();
		
		require_once('application/libraries/Configeditor.php');

        requirePermission("viewSlider");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Manage slider");

        $slides = $this->cms_model->getSlides();

        if ($slides) {
            foreach ($slides as $key => $value) {
                $slides[$key]['image'] = preg_replace("/{path}/", "", $value['image']);

                if (strlen($slides[$key]['image']) > 15) {
                    $slides[$key]['image'] = "..." . mb_substr($slides[$key]['image'], strlen($slides[$key]['image']) - 15, 15);
                }

                if (strlen($value['header']) > 16) {
                    $slides[$key]['header'] = mb_substr($value['header'], 0, 16) . '...';
                }
            }
        }

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'slides' => $slides,
            "slider" => $this->config->item('slider'),
            "slider_home" => $this->config->item('slider_home'),
            "slider_interval" => $this->config->item('slider_interval'),
            "slider_style" => $this->config->item('slider_style')
        );

        // Load my view
        $output = $this->template->loadPage("slider/slider.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Slides', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/slider.js");
    }

    public function create()
    {
        requirePermission("addSlider");

        $data["image"] = $this->input->post("image");
        $data["header"] = $this->input->post("text_header");
        $data["body"] = $this->input->post("text_body");
        $data["footer"] = $this->input->post("text_footer");

        if (empty($data["image"])) {
            die("Image can't be empty");
        }

        if (!preg_match("/http:\/\//", $data['image'])) {
            $data['image'] = "{path}" . $data['image'];
        }

        $this->slider_model->add($data);

        die("yes");
    }

    public function edit($id = false)
    {
        if (!is_numeric($id) || !$id) {
            die();
        }

        $slide = $this->slider_model->getSlide($id);

        if (!$slide) {
            show_error("There is no slide with ID " . $id);

            die();
        }

        // Change the title
        $this->administrator->setTitle('Slide #' . $slide['id']);

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'slide' => $slide
        );

        // Load my view
        $output = $this->template->loadPage("slider/edit_slider.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'admin/slider">Manage slider</a> &rarr; Slide #' . $slide['id'], $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/slider.js");
    }

    public function new()
    {
        // Change the title
        $this->administrator->setTitle('Add slider');

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
        );

        // Load my view
        $output = $this->template->loadPage("slider/add_slider.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Add slider', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/slider.js");
    }

    public function move($id = false, $direction = false)
    {
        requirePermission("editSlider");

        if (!$id || !$direction) {
            die();
        } else {
            $order = $this->slider_model->getOrder($id);

            if (!$order) {
                die();
            } else {
                if ($direction == "up") {
                    $target = $this->slider_model->getPreviousOrder($order);
                } else {
                    $target = $this->slider_model->getNextOrder($order);
                }

                if (!$target) {
                    die();
                } else {
                    $this->slider_model->setOrder($id, $target['order']);
                    $this->slider_model->setOrder($target['id'], $order);
                }
            }
        }
    }

    public function saveSettings()
    {
        requirePermission("editSlider");

        $slider = $this->input->post("show_slider");

        if (!is_numeric($this->input->post("slider_interval")) || !$this->input->post("slider_interval")) {
            $slider_interval = 3000;
        } else {
            $slider_interval = (int)$this->input->post("slider_interval") * 1000;
        }

        $slider_style = $this->input->post("slider_style");

        if ($slider == "always") {
            $slider = true;
            $slider_home = false;
        } elseif ($slider == "home") {
            $slider = true;
            $slider_home = true;
        } else {
            $slider = false;
            $slider_home = false;
        }

        $fusionConfig = new ConfigEditor("application/config/fusion.php");

        $fusionConfig->set('slider', $slider);
        $fusionConfig->set('slider_interval', $slider_interval);
        $fusionConfig->set('slider_home', $slider_home);
        $fusionConfig->set('slider_style', $slider_style);

        $fusionConfig->save();

        die("yes");
    }

    public function save($id = false)
    {
        requirePermission("editSlider");

        if (!$id || !is_numeric($id)) {
            die();
        }

        $data["image"] = $this->input->post("image");
        $data["header"] = $this->input->post("text_header");
        $data["body"] = $this->input->post("text_body");
        $data["footer"] = $this->input->post("text_footer");

        if (!preg_match("/http:\/\//", $data['image'])) {
            $data['image'] = "{path}" . $data['image'];
        }

        $this->slider_model->edit($id, $data);

        die('window.location="' . $this->template->page_url . 'admin/slider"');
    }

    public function delete($id = false)
    {
        requirePermission("deleteSlider");

        if (!$id || !is_numeric($id)) {
            die();
        }

        $this->slider_model->delete($id);
    }
}
