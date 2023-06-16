<?php

class Avatar extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        $this->load->config('settings');
        $this->load->model("settings_model");
    }

    public function index()
    {
        // Prepare data
        $data = array(
            'isStaff'	=> $this->user->isStaff(),
            'avatar' 	=> $this->user->getAvatar($this->user->getId()),
            'avatarId'	=> $this->user->getAvatarId($this->user->getId()),
            'avatars'	=> $this->settings_model->get_all_avatars()
        );

        // Load the avatar page
		$content = $this->template->loadPage("avatar.tpl", $data);

		$title = lang("change_avatar", "ucp");

		// Put it in a content box
		$this->template->box($title, $content, true, "modules/ucp/css/avatar.css", "modules/ucp/js/avatar.js");
    }

    public function change()
    {
		$avatar_id = $this->input->post('avatar_id');

		$avatar = $this->settings_model->get_avatar_id($avatar_id);
		if(!$avatar)
        {
			die(json_encode(array("error" => lang("avatar_invalid", "ucp"))));
		}
		
		if($avatar['staff'] && !$this->user->isStaff())
        {
			die(json_encode(array("error" => lang("avatar_invalid_rank", "ucp"))));
		}
		
		$this->user->setAvatar($avatar['id']);
		die(json_encode(array("success" => true)));
	}
}
