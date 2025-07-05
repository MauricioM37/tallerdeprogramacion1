<?php

namespace App\Models;

use CodeIgniter\Model;

class usuario_Model extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';
    protected $allowedFields = ['nombre', 'apellido',"id_perfil","direccion" ,"ciudad","provincia","telefono",'usuario','email', 'pass', 'baja'];
}
