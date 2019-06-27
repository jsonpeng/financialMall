<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\GaobaoRepository;

use App\Models\Gaobao;

class GaobaoController extends Controller
{

	private $gaobaoRepository;

    public function __construct(GaobaoRepository $gaobaoRepo)
    {
        $this->gaobaoRepository = $gaobaoRepo;
    }

    public function index()
    {
    	$gaobaos = Gaobao::orderBy('created_at', 'desc')->get();
    	return response()->json(['status_code' => 0, 'data' => ['products' => $gaobaos]] );
    }
}
