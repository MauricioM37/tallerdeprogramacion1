<?php

namespace App\Controllers;

use App\Models\EnviosModel;
use CodeIgniter\Controller;

class ComprasUsuarioController extends Controller
{ // fix para que coincidad con id
    public function index()
    {
        $EnviosModel = new EnviosModel();
        $data['envios'] = $EnviosModel->findAll();
        return view('compras_usuario', $data);
    }
}
