<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    //logs
    public function logs()
    {
        //ifsearchterm
        if (request()->has('searchTerm')) {
            $query = \App\Models\Log::where('message', 'like', "%".request('searchTerm')."%");

            if($query->count() == 0) {
                return redirect()->route('logs')->with('success', 'No se encontraron resultados');
            }else{
                return view('logs.index', [
                    'logs' => $query->orderBy('id', 'desc')->paginate(10)
                ]);
            }

        }
        return view('logs.index',
            [
                'logs' => \App\Models\Log::orderBy('id', 'desc')->paginate(10)
            ]);
    }
}
