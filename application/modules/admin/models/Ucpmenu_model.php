<?php

class Ucpmenu_model extends CI_Model
{
    public function getMenuLinks(): bool|array
    {
        $query = $this->db->table('menu_ucp')
            ->select(['id', 'name', 'description', 'link', 'icon', 'order', 'group', 'permission', 'permissionModule'])
            ->orderBy('`group`', 'ASC')
            ->orderBy('`order`', 'ASC')
            ->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getMenuLink($id)
    {
        $query = $this->db->query("SELECT * FROM menu_ucp WHERE id = ?", [$id]);

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        if ($this->db->query("DELETE FROM menu_ucp WHERE id = ?", [$id])) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id, $data)
    {
        $this->db->table('menu_ucp')->where('id', $id)->update($data);
    }

    public function add($name, $description, $link, $icon, $group, $permission, $permissionModule)
    {
        $data = [
            "name" => $name,
            "description" => $description,
            "link" => $link,
            "icon" => $icon,
            "group" => $group,
            "permission" => $permission,
            "permissionModule" => $permissionModule
        ];

        $this->db->table('menu_ucp')->insert($data);

        $query = $this->db->query("SELECT id FROM menu_ucp ORDER BY id DESC LIMIT 1");
        $row = $query->getResultArray();

        $this->db->query("UPDATE menu_ucp SET `order` = ? WHERE id = ?", [$row[0]['id'], $row[0]['id']]);
    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT `order` FROM menu_ucp WHERE `id`=? LIMIT 1", [$id]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['order'];
        } else {
            return false;
        }
    }

    public function getPreviousOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM menu_ucp WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", [$order]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNextOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM menu_ucp WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", [$order]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function setOrder($id, $order)
    {
        $this->db->query("UPDATE menu_ucp SET `order`=? WHERE `id`=? LIMIT 1", [$order, $id]);
    }
}
