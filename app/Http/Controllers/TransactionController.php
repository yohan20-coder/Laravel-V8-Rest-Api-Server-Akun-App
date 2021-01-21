<?php

namespace App\Http\Controllers;

use App\Models\Transaction;             //memanggil model transaction
use GuzzleHttp\Psr7\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;   //memanggil namespace validator untuk api
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //menampilkan data dari model
        $transaction = Transaction::orderBy('time', 'DESC')->get();
        $response =[
            'message' => 'List Transaction Order By Time',
            'data' => $transaction
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi inputan api
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'amount' => ['required','numeric'],
            'type'  => ['required','in:expense,revenue']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //response jika berhasil di validasi
        try {
            $transaction = Transaction::create($request->all());            //request->all : mengambil semua inputan
            $response = [
                'message' => 'Transaction Created',
                'data' => $transaction
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {                   //jika response gagal
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         //mencek data di database dengan param $id
         $transaction = Transaction::findOrFail($id);
         $response = [
            'message' => 'Detail Of Transaction Resource',
            'data' => $transaction
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //mencek data di database dengan param $id
        $transaction = Transaction::findOrFail($id);

        //validasi inputan api
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'amount' => ['required','numeric'],
            'type'  => ['required','in:expense,revenue']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //response jika berhasil di validasi
        try {
            $transaction->update($request->all());            //request->all : mengambil semua inputan
            $response = [
                'message' => 'Transaction Update',
                'data' => $transaction
            ];
            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {                   //jika response gagal
            return response()->json([
                'message' => "Failed". $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //mencek data di database dengan param $id
         $transaction = Transaction::findOrFail($id);        
         //response jika berhasil di validasi
         try {
             $transaction->delete();            //request->all : mengambil semua inputan
             $response = [
                 'message' => 'Transaction Delete'
             ];
             return response()->json($response, Response::HTTP_OK);
 
         } catch (QueryException $e) {                   //jika response gagal
             return response()->json([
                 'message' => "Failed". $e->errorInfo
             ]);
         }
    }
}
