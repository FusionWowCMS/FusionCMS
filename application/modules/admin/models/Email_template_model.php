<?php

class Email_template_model extends CI_Model
{
    public function getTemplates()
    {
        $query = $this->db->query("SELECT * FROM email_templates");

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row;
        } else {
            return false;
        }
    }

    public function getTemplate($id)
    {
        $query = $this->db->query("SELECT * FROM email_templates WHERE id= ? LIMIT 1", array($id));

        if ($query->getNumRows() > 0)
		{
            $row = $query->getResultArray();
            return $row[0];
        } else {
            return false;
        }
    }
}
