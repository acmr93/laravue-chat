<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MensajeEnviado;
use App\Mensaje;


class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('chat');
    }

    public function ObtenerMensajes()
    {
        return Mensaje::with('user')->get();
    }

    public function EnviarMensajes(Request $request)
    {
        $mensaje = auth()->user()->mensajes()->create([
            'valor' => $request->valor
        ]);

        broadcast(new MensajeEnviado($mensaje->load('user')))->toOthers();


        return ['status' => 'Bien'];
    }
}
