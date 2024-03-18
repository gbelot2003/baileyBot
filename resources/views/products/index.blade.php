@extends('layouts.app')

@section('content')
<div class="container-flex">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Listado de Productos</h5>
                    <div class="card-text">
                        <table class="table table-hover table-color">
                            <thead>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Tag</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->tag }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td><a href="{{ route('products.edit', $product->id) }}">Editar</a> | Borrar</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@stop
