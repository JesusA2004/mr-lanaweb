<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FaqQuestionMail;

class FaqQuestionController extends Controller {

    public function store(Request $request) {
        $data = $request->validate([
            'nombre'   => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'max:190'],
            'pregunta' => ['required', 'string', 'max:1500'],
        ]);
        // destino configurable
        $to = config('mail.to.address') ?: config('mail.from.address');
        Mail::to($to)->send(new FaqQuestionMail($data));
        return response()->json(['ok' => true]);
    }

}
