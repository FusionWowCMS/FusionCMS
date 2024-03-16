<?php

class Slider_model extends CI_Model
{
    public function add($data)
    {
        $this->db->table('image_slider')->insert($data);

        $query = $this->db->query("SELECT id FROM image_slider ORDER BY id DESC LIMIT 1");
        $row = $query->getResultArray();

        $this->db->query("UPDATE image_slider SET `order` = ? WHERE id = ?", array($row[0]['id'], $row[0]['id']));
    }

    public function edit($id, $data)
    {
        $this->db->table('image_slider')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM image_slider WHERE id = ?", [$id]);
    }

    public function getSlide($id)
    {
        $query = $this->db->query("SELECT * FROM image_slider WHERE id = ? LIMIT 1", [$id]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT `order` FROM image_slider WHERE `id` = ? LIMIT 1", [$id]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['order'];
        } else {
            return false;
        }
    }

    public function getPreviousOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM image_slider WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", [$order]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNextOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM image_slider WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", [$order]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function setOrder($id, $order)
    {
        $this->db->query("UPDATE image_slider SET `order` = ? WHERE `id` = ? LIMIT 1", [$order, $id]);
    }
}
