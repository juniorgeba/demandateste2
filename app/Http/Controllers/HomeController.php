<?php

namespace App\Http\Controllers;

use App\Models\Medida;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function dashboard()
    {
        // Agrupa as medidas por status e conta quantas existem em cada status
        $medidasPorStatus = Medida::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('dashboard', compact('medidasPorStatus'));

    }

}
