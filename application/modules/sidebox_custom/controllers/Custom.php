<?php

use MX\MX_Controller;

/**
 * Custom Controller Class
 * @property custom_model $custom_model custom_model Class
 */
class Custom extends MX_Controller
{
    private $id;

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;
        $this->load->model('sidebox_custom/custom_model');
    }

    public function view()
    {
        // Get the custom data
        $data = $this->custom_model->getCustomData($this->id);
        
		if($data)
		{
			// Return the custom data
            return langColumn($data['content']);
		}
    }
}
