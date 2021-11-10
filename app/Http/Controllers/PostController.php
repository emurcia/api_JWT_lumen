<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// añadido modelo product
use App\Models\Product;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {

            return Response([
                'status' => 'error',
                'stauscode' => 404,
                'message' => "El producto con id: {$id} no existe"
            ]);
        }
        // devolvemos el json con los datos
        return Response([
            'status' => 'success',
            'stauscode' => 200,
            'data' => $product
        ]);
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

        $this->validate(
            $request,
            [
                'name' => 'required',
                'price' => 'required',
                'description' => 'required'
            ]
        );



        // buscamos el registro segun $id
        $product = Product::find($id);

        if (!$product) {

            return Response([
                'status' => 'error',
                'stauscode' => 404,
                'message' => "El producto con id: {$id} no existe"
            ]);
        }

        // asignamos los valores que se estan modificando
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;


        // guardamos el registro
        $product->save();

        // retornamos confirmacion al usuario
        return Response([
            'status' => 'success',
            'stauscode' => 204,
            'data' => 'El Producto se actualizo exitosamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // buscamos el registro segun $id
        $product = Product::find($id);

        // eliminamos el registro
        $product->delete();

        // retornamos confirmacion al usuario
        return Response([
            'status' => 'success',
            'stauscode' => 202,
            'data' => 'El Producto Fue Eliminado exitosamente'
        ]);
    }
}