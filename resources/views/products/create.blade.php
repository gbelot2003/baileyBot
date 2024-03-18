@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Producto</h5>
                    <div class="card-text">
                        {{ Form::open(['route' => 'products.store']) }}
                            @include('products._form', ['name' => 'Crear'])
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
