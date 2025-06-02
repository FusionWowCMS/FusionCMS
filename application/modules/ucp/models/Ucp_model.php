<?php

class Ucp_model extends CI_Model
{
    public function getMenu(): array
    {
        return $this->db->table('menu_ucp')
            ->select(['id', 'name', 'description', 'link', 'icon', 'order', 'group', 'permission', 'permissionModule'])
            ->orderBy('`group`', 'ASC')
            ->orderBy('`order`', 'ASC')
            ->get()->getResultArray();
    }
}
