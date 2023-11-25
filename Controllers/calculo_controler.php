<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class calculo_controler extends Controller
{
    public function processar(Request $request)
    {
        $response = []; // Resposta a ser enviada
        $cargaHoraria = $request->cargaHoraria;
        $salarioBruto = $request->salarioBruto;
        $QtdHE = $request->QtdHE;
        $porcHE = $request->porcHE;


        if ($salarioBruto <= 0) {
            $response['success'] = false;
            $response['message'] = 'Salário não é válido.';
            return response()->json($response);
        }
        function tratarNumero($numero){
            $numero = str_replace([' ', '.'], '', $numero);
            $numero = str_replace(',', '.', $numero);
            $num = (float)$numero;
            return $num;
        }

        $salarioBrutoFormatado= tratarNumero($salarioBruto);

        $salarioHora = number_format($salarioBrutoFormatado / $cargaHoraria,2);
        $valorHE = number_format($salarioHora * ($porcHE + 100) / 100 * $this->converterHorarioParaHoras($QtdHE), 2, ',', '');

        $response['success'] = true;
        $response['salarioBruto'] = 'R$ '.$salarioBruto;
        $response['cargaHoraria'] = $cargaHoraria;
        $response['QtdHE'] = $QtdHE;
        $response['porcHE'] = $porcHE;
        $response['salarioHora'] = $salarioHora;
        $response['valorHE'] = $valorHE;

        return response()->json($response);
    } 
    public function converterHorarioParaHoras($QtdeHE)
        {
             list($horas, $minutos) = explode(':', $QtdeHE);
             return $horas + ($minutos / 60);
         }   


}