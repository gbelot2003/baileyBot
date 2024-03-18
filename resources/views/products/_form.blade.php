<hr>
<div class="form-group">
    <label for="name">Nombre</label>
    {{ Form::text('name', null, ['class' => 'form-control']) }}
</div>
<br>

<div class="form-group">
    <label for="name">Tag</label>
    {{ Form::Select('tag', ['camas' => 'camas', 'sillas' => 'sillas', 'miselaneos' => 'miselaneos'], null,  ['class' => 'form-control']) }}
</div>
<br>

<div class="form-group">
    <label for="name">Descrición</label>
    {{ Form::textarea('descricion', null, ['class' => 'form-control']) }}
</div>
<br>
<div class="form-group">
    <label for="name">precio</label>
    {{ Form::text('price', null, ['class' => 'form-control']) }}
</div>
<br>
<div class="form-group">
    <label for="name">Imagen URL</label>
    {{ Form::text('image_url', null, ['class' => 'form-control']) }}
</div>
<br>

<div class="form-group">
    <a href="{{ route('products.index') }}" class="btn btn-warning">Cancelar</a>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</div>
