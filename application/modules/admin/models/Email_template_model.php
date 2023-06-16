<?php

class Email_template_model extends CI_Model
{
    public function getTemplates()
    {
        $query = $this->db->query("SELECT * FROM email_templates");

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function getTemplate($id)
    {
        $query = $this->db->query("SELECT * FROM email_templates WHERE id= ? LIMIT 1", array($id));

        if ($query->num_rows() > 0)
		{
            $row = $query->result_array();
            return $row[0];
        } else {
            return false;
        }
    }
}
