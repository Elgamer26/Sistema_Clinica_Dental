<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloUsuario;
use App\Models\ModeloCompras;
use App\Models\ModeloProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Echo_;
use setasign\Fpdi\Fpdi;

class ControllerCompras extends BaseController
{

    protected $usuario;
    protected $producto;
    protected $compra;
    public function __construct()
    {
        date_default_timezone_set('America/Guayaquil'); // Cambia a tu zona horaria
        $this->compra = new ModeloCompras();
        $this->producto = new ModeloProducto();
        $this->usuario = new ModeloUsuario();
        session_start();
    }

    // VISTAS **************************************
    public function nueva_compra()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->producto->listado_producto(0);
            $data = [
                'fecha' => date('Y-m-d'),
                'lista' =>  $repuesta_lista
            ];
            return view('compra/form_nueva_compra', $data);
        }
    }

    public function lista_compras()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->compra->listado_compras(0);
            $data = [
                'fecha' => date('Y-m-d'),
                'lista' =>  $repuesta_lista
            ];
            return view('compra/form_lista_compra', $data);
        }
    }

    public function crear_compra(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $fecha  = $request->fecha;
                $tipo_comprabante  = $request->tipo_comprabante;
                $iva  = $request->iva;
                $numero_factura = $request->numero_factura;
                $subtotal = $request->subtotal;
                $impuesto_sub = $request->impuesto_sub;
                $total_pagar = $request->total_pagar;

                $id_p = (string)$request->id_p;
                $precio = (string)$request->precio;
                $cantidad = (string)$request->cantidad;

                $arraglo_id_p = explode(",", $id_p); //aqui separo los datos
                $arraglo_precio = explode(",", $precio); //aqui separo los datos
                $arraglo_cantidad = explode(",", $cantidad); //aqui separo los datos

                $repuesta_create = $this->compra->crear_compra($_SESSION["iduser"], $fecha, $tipo_comprabante, $iva, $numero_factura, $subtotal, $impuesto_sub, $total_pagar);

                if ($repuesta_create > 0) {

                    for ($i = 0; $i < count($arraglo_id_p); $i++) {
                        $repuesta_create = $this->compra->detalle_compra($repuesta_create, $arraglo_id_p[$i], $arraglo_precio[$i], $arraglo_cantidad[$i]);
                    }

                    return response()->json(['success' => 'Comprar ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    //******************************************//

    public function detalle_compra($id)
    {
        $repuesta  = $this->compra->listado_compras($id);

        if (empty($repuesta )){
            return redirect()->route('compra.form_lista_compra');  // login
        }
        
        $pdf = new \FPDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->SetTopMargin(15);
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);

        $imagePath =  public_path('img/logos/diente.png');
        $detalle  = $this->compra->listado_compras_detalle($id);
        $empresa  = $this->usuario->listar_empresa();

        $pdf->SetTitle("Compra producto");
        //$pdf->Image(base_url() . 'public/img/empresa/borde.png', 0, 0, 210, 300);
        $pdf->Image($imagePath, 15, 5, 30);
        $pdf->SetFont('times', 'B', 13);
        $pdf->Text(90, 15, "Empresa: " . utf8_decode($empresa["nombre"]), 1, '', 'C', 1);
        $pdf->Text(90, 21, "Direc: " . utf8_decode($empresa["direccion"]), 1, '', 'C', 1);
        $pdf->Text(90, 27, "Telf: : " . utf8_decode($empresa["telefono"]), 1, '', 'C', 1);
        $pdf->Text(90, 33, "Correo: " . utf8_decode($empresa["correo"]), 1, '', 'C', 1);
        $pdf->Text(90, 39, "Compra de producto", 1, '', 'C', 1);

        //información de # de factura
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text(140, 48, utf8_decode('N. Comprobante:'));
        $pdf->SetFont('Arial', '', 10);
        $pdf->Text(170, 48, $repuesta[3]);

        // Agregamos los datos del cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Text(15, 48, utf8_decode('Fecha:'));
        $pdf->SetFont('Arial', '', 10);
        $pdf->Text(30, 48,  date('d/m/Y', strtotime($repuesta[1])));

        // Agregamos los datos de la factura
        // $pdf->SetFont('Arial', 'B', 10);
        // $pdf->Text(15, 54, utf8_decode('Proveedor:'));
        // $pdf->SetFont('Arial', '', 10);
        // $pdf->Text(35, 54, "compra[2]");

        $pdf->Ln(42);

        $pdf->SetX(15);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(181, 217, 119);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(12, 12, utf8_decode('N°'), 0, 0, 'C', 1);
        $pdf->Cell(80, 12, utf8_decode('Producto'), 0, 0, 'C', 1);
        $pdf->Cell(30, 12, utf8_decode('Precio'), 0, 0, 'C', 1);
        $pdf->Cell(30, 12, utf8_decode('Cantidad'), 0, 0, 'R', 1);
        $pdf->Cell(30, 12, utf8_decode('Total'), 0, 1, 'R', 1);

        $pdf->SetFont('Arial', '', 10);

        for ($i = 0; $i < count($detalle); $i++) {
            $pdf->SetX(15); //posicionamos en x
            if ($i % 2 == 0) {
                $pdf->SetFillColor(232, 232, 232);
                $pdf->SetDrawColor(65, 61, 61);
            } else {
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetDrawColor(65, 61, 61);
            }
            $pdf->Cell(12, 8, $i + 1, 'B', 0, 'C', 1);
            $pdf->Cell(80, 8, utf8_decode($detalle[$i]["nombre"]), 'B', 0, 'C', 1);
            $pdf->Cell(30, 8, "$ " . utf8_decode($detalle[$i]["precio"]), 'B', 0, 'C', 1);
            $pdf->Cell(30, 8, utf8_decode($detalle[$i]["cantidad"]), 'B', 0, 'R', 1);
            $pdf->Cell(30, 8, "$ " . utf8_decode($detalle[$i]["cantidad"] * $detalle[$i]["precio"]), 'B', 1, 'R', 1);
            $pdf->Ln(0.5);
        }

        $pdf->Ln(10);
        $pdf->setX(95);
        $pdf->Cell(40, 6, 'Subtotal', 1, 0);
        $pdf->Cell(60, 6, "$ $repuesta[4]", '1', 1, 'R');
        $pdf->setX(95);
        $pdf->Cell(40, 6, 'Impuesto', 1, 0);
        $pdf->Cell(60, 6, "$ $repuesta[5]", '1', 1, 'R');
        $pdf->setX(95);
        $pdf->Cell(40, 6, 'Total', 1, 0);
        $pdf->Cell(60, 6, "$ $repuesta[6]", '1', 1, 'R');

        // if ($compra[8] != 1) {
        //     $pdf->Image(base_url() . 'public/img/anulado.png', 80, 250, 60);
        // }

        return response($pdf->Output("compra_pdf.pdf", "I"))->header('Content-Type', 'application/pdf');
    }
}
