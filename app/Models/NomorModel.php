<?php

namespace App\Models;

use CodeIgniter\Model;

class NomorModel extends Model
{
    protected $table = 'nomor';
    protected $primaryKey = 'id';
    protected $allowedFields = ['no_hp', 'provider'];
}
