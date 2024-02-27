@extends('layouts.mail')

@section('body')
    <div class="text-center" style="color: rgb(124, 123, 123); text-align: center!important;box-sizing: border-box;">
        <br />
        @if ($nombre)
            <p class="text-center font-weight-bold"
                style="font-weight: 700!important;text-align: center!important;margin-top: 0;margin-bottom: 1rem;box-sizing: border-box;">
                Hola
            </p>
            <p class="text-center font-weight-bold"
                style="color:#002F86; font-size: xx-large;font-weight: 700!important;text-align: center!important;margin-top: 0;margin-bottom: 1rem;box-sizing: border-box;">
                {{ $nombre }}
            </p>
        @endif
        <p class="text-center font-weight-bold" style="color:#002F86; font-size: xx-large;font-weight: 700!important;text-align: center!important;margin-top: 0;margin-bottom: 1rem;box-sizing: border-box;">
            cotización
        </p>
        <p class="text-justify" style="text-align: justify!important;margin-top: 0;margin-bottom: 1rem;box-sizing: border-box;">
            <table class="table">
                <thead>
                    <th>

                    </th>
                    <th>
                        Nombre del Producto
                    </th>
                    <th>
                        Precio del Producto
                    </th>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    <tr>
                        <td><img width="200" class="img img-thumbnail" src="{{ $producto->image_url }}" alt="{{ $producto->name }}"></td>
                        <td>{{ $producto->name }}</td>
                        <td>Lps. {{ number_format($producto->price, 2, '.', '') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </p>
    </div>
@stop
