<?php

class Changelog_model extends CI_Model
{
    public function add($data)
    {
        $this->db->table('changelog')->insert($data);
    }

    public function getChangelog($limit = false)
    {
        if ($limit) {
            $query = $this->db->query("SELECT * FROM changelog c, changelog_type t WHERE c.type = t.id ORDER BY c.time DESC LIMIT ?", [$limit]);
        } else {
            // This query also gets the type from the foreign key.
            $query = $this->db->query("SELECT * FROM changelog c, changelog_type t WHERE c.type = t.id ORDER BY c.time DESC");
        }

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getChange($id)
    {
        if (!$id) {
            return false;
        } else {
            $query = $this->db->query("SELECT * FROM changelog c, changelog_type t WHERE c.type = t.id AND c.change_id = ?", [$id]);

            if ($query->getNumRows() > 0) {
                $result = $query->getResultArray();
                return $result[0];
            } else {
                return false;
            }
        }
    }

    public function getCategories()
    {
        $query = $this->db->query("SELECT * FROM changelog_type ORDER BY id ASC");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function addCategory($name): int|string
    {
        $this->db->query("INSERT INTO changelog_type(typeName) VALUES(?)", [$name]);

        return $this->db->insertID();
    }

    public function deleteChange($id)
    {
        $this->db->query("DELETE FROM changelog WHERE change_id = ?", [$id]);
    }

    public function deleteCategory($id)
    {
        $this->db->query("DELETE FROM changelog WHERE type = ?", [$id]);
        $this->db->query("DELETE FROM changelog_type WHERE id = ?", [$id]);
    }

    public function addChange($text, $category)
    {
        $data = [
            "changelog" => $text,
            "author" => $this->user->getNickname(),
            "type" => $category,
            "time" => time()
        ];

        $this->db->table('changelog')->insert($data);

        $query = $this->db->query("SELECT change_id FROM changelog ORDER BY change_id DESC LIMIT 1");

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['change_id'];
        } else {
            return false;
        }
    }

    public function saveCategory($id, $data)
    {
        $this->db->table('changelog_type')->where('id', $id)->update($data);
    }

    public function edit($id, $data)
    {
        $this->db->table('changelog')->where('change_id', $id)->update($data);
    }
}
