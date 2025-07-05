<?php

namespace App\Controllers;

use App\Models\EnviosModel;
use App\Models\TiposModel;
use CodeIgniter\Controller;
use App\Models\DetalleEnviosModel;
//en el caso que no ande envios controller considerar este 
class VentasAdminController extends Controller
{
    public function index()
    {
        $TiposModel = new TiposModel();
        $data['productos'] = $TiposModel->getActiveProducts();

        $EnviosModel = new EnviosModel();
        $data['ventas'] = $EnviosModel->findAll();

        echo view('ventas_admin', $data);
    }

    public function guardarVenta()
    {   
        if ($this->request->getMethod() === 'post') {
            $EnviosModel = new EnviosModel();

            $data = [
                'id_cliente' => session()->get('id_usuario'),
                'fecha_venta' => date('Y-m-d H:i:s'),
                'subtotal' => ($this->request->getPost('subtotal') * 100),
            ];

            try {
                $EnviosModel->insert($data);
                return redirect()->to(base_url('/productos'))->with('success', 'Venta realizada con éxito.');
            } catch (\Exception $e) {
                return "Error al insertar la venta: " . $e->getMessage();
            }
        } else {
            return "Error: Método no permitido";
        }
    }

    public function cargarVentas()
    {
        $EnviosModel = new EnviosModel();
        $ventas = $EnviosModel->findAll();
        return $this->response->setJSON(['ventas_admin' => $ventas]);
    }

    public function indexUser()
    {
        $EnviosModel = new EnviosModel();
        $session = session();
        $datosCompra['compras']   = $EnviosModel->where('id_cliente', $session->get('id_usuario'))->join("usuarios", "usuarios.id_usuario = historial_ventas.id_cliente")->findAll();
    
        echo view ('compras_usuario', $datosCompra);
    }



}