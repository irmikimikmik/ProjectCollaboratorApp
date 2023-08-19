<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DropTablesSeeder extends Seeder
{
    public function run()
    {
        $this->db->query("DROP TABLE IF EXISTS bug");
        $this->db->query("DROP TABLE IF EXISTS feature");
        $this->db->query("DROP TABLE IF EXISTS notificationtypedescmap");
        $this->db->query("DROP TABLE IF EXISTS userhasrole");
        $this->db->query("DROP TABLE IF EXISTS TestingCoverageStatusMap");
        $this->db->query("DROP TABLE IF EXISTS testing");
        $this->db->query("DROP TABLE IF EXISTS teamhaspeople");
        $this->db->query("DROP TABLE IF EXISTS team");
        $this->db->query("DROP TABLE IF EXISTS SecurityCVSSSeverityMap");
        $this->db->query("DROP TABLE IF EXISTS security");
        $this->db->query("DROP TABLE IF EXISTS requesttojoin");
        $this->db->query("DROP TABLE IF EXISTS task");
        $this->db->query("DROP TABLE IF EXISTS postneedsrole");
        $this->db->query("DROP TABLE IF EXISTS post");
        $this->db->query("DROP TABLE IF EXISTS role");
        $this->db->query("DROP TABLE IF EXISTS project");
        $this->db->query("DROP TABLE IF EXISTS notification");
        $this->db->query("DROP TABLE IF EXISTS appuser");
    }
}
