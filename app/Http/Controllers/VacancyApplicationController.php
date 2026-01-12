<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacancyApplicationRequest;
use App\Mail\VacancyApplicationMail;
use Illuminate\Support\Facades\Mail;

class VacancyApplicationController extends Controller {
    
    public function store(VacancyApplicationRequest $request) {
        $data = $request->validated();

        // Destino temporal (luego lo cambias)
        $to = config( 'jesusarizmendimaya@gmail.com');

        Mail::to($to)->send(new VacancyApplicationMail($data));

        return back()->with('success', 'Tu postulación fue enviada. En breve nos pondremos en contacto.');
    }

}
