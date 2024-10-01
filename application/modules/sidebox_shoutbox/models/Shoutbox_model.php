<?php

class Shoutbox_model extends CI_Model
{
    public function getShouts($start, $end): array
    {
        $query = $this->db->table('shouts')->select()->limit($end, $start)->orderBy('id', 'DESC')->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return [];
        }
    }

    public function getCount(): int
    {
        $query = $this->db->table('shouts')->select('COUNT(*) as `total`')->get();

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['total'];
        } else {
            return 0;
        }
    }

    public function insertShout($content): void
    {
        $data = [
            'author' => $this->user->getId(),
            'content' => $content,
            'date' => time(),
            'is_gm' => hasPermission("shoutAsStaff", "sidebox_shoutbox")
        ];

        $this->db->table('shouts')->insert($data);
    }

    public function deleteShout($id): void
    {
        $this->db->table('shouts')->where('id', $id)->delete();
    }
}
