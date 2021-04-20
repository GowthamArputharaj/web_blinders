<?php

namespace App\Http\Controllers;

use App\Models\FormData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WebBlindersForm extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:24',
            'email' => 'required|email',
            'message' => 'max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        } else {

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message ?? null,
            ];

            DB::table('form_data')->insert($data);

            return response()->json(['message' => 'Saved Data Successfully'], 200);
        }
    }
}
