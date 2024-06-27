<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact');
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|string|email',
            'mensaje' => 'required|string',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'mensaje' => $request->mensaje,
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data) {
            $message->to('revista@tallerphp.uy')
                    ->subject('Nuevo mensaje de contacto')
                    ->from($data['email'], $data['nombre']);
        });

        return redirect()->back()->with('success', 'Mensaje enviado exitosamente');
    }
}
