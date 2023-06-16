<?php

class Vote extends MX_Controller
{
    private $js;
    private $css;

    public function __construct()
    {
        parent::__construct();

        //Make sure that we are logged in
        $this->user->userArea();

        // Set JS and CSS paths
        $this->js = "modules/vote/js/vote.js";
        $this->css = "modules/vote/css/vote.css";

        //Load the model and config
        $this->load->config('vote');
        $this->load->model('vote_model');
        $this->load->helper('form');
    }

    public function index()
    {
        requirePermission("view");

        clientLang("hours_remaining", "vote");

        $this->template->setTitle(lang("vote_panel", "vote"));

        $voteData = array(
            'path' => $this->template->page_url,
            'vote_sites' => $this->vote_model->getVoteSites(),
            'formAttributes' => array('target' => '_blank')
        );

        $output = $this->template->loadPage("vote.tpl", $voteData);

        // Load the topsite page and format the page contents
        $data = array(
            "module" => "default",
            "headline" => breadcumb(array(
                            "ucp" => lang("ucp"),
                            "ucp/avatar" => lang("vote_panel", "vote")
                        )),
            "content" => $output
        );

        $page = $this->template->loadPage("page.tpl", $data);

        //Load the template form
        $this->template->view($page, $this->css, $this->js);
    }

    public function site()
    {
        $api = array(
            "user_id" => $this->user->getId(),
            "username" => $this->user->getUsername(),
            "user_ip" => $this->input->ip_address()
        );

        $vote_site_id = $this->input->post('id'); //The site where we are voting for.

        if (!$vote_site_id) {
            die("Please specify topsite ID");
        }

        //Get the vote site info, returns false if the site does not exists!!
        $vote_site = $this->vote_model->getVoteSite($vote_site_id);

        //Check if they already voted with that ip.
        $can_vote = $this->vote_model->canVote($vote_site_id);

        //Check if that site exists and that the user didn't voted for it yet.
        if ($vote_site && $can_vote) {
            //Update the vp if needed or else just go to the url if we got vote callback enabled.
            if ($vote_site['callback_enabled']) {
                $vote_url = preg_replace("/\{user_id\}/", $this->user->getId(), $vote_site['vote_url']);

                if ($this->input->post("isFirefoxHerpDerp")) {
                    die($vote_url);
                }

                redirect($vote_url);
            } else {
                $this->vote_model->vote_log($api['user_id'], $api['user_ip'], $vote_site_id);

                $this->vote_model->updateVp($this->user->getId(), $vote_site['points_per_vote']);

                $this->plugins->onVote($api['user_id'], $vote_site);

                if ($this->input->post("isFirefoxHerpDerp")) {
                    die($vote_site['vote_url']);
                }

                redirect($vote_site['vote_url']);
            }
        } else {
            die(lang("already_voted", "vote"));
        }
    }
}
