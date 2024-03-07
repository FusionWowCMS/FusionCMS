<?php defined('BASEPATH') or exit('No direct script access allowed');

class latest_article_model extends CI_Model
{
    public function getArticles($start = 0, $limit = 1)
    {
        if ($start === true) {
            $this->db->select('*');
        } else {
            $this->db->select('*');
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('articles');
        $result = $query->result_array();

        // Did we have any results?
        if ($result) {
            return $this->template->format($result);
        } else {
            // Instead of showing a blank space, we show a default article
            return [
                [
                    'id' => 0,
                    'headline' => 'Welcome to your new FusionCMS powered website!',
                    'content' => 'Your website has been successfully installed and we, the FusionCMS team, sincerely hope that you will have a nice time using it.<div><br></div><div>To proceed, log into the administrator panel using an administrator account and the security code you specified during the installation.</div><div><br></div><br><div>Best regards,</div><div>the FusionCMS team</div>',
                    'author_id' => 0,
                    'timestamp' => time(),
                    'type' => 0,
                    'type_content' => null,
                    'comments' => -1
                ]
            ];
        }
    }

}
