@if (Auth::user()->refresh_token != '')
<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group">
                <label>Agregar imágenes</label>
                <a href="/admin/editphoto/{{ $post_id }}" class="btn btn-primary btn-block">Nueva imagen</a>
            </div>
        </div>
    </div>
</div>
@else
<div class="col-md-8">
    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group">
                <a class="btn btn-success" href="{{route('login.google')}}">Agregar Cuenta Drive</a>
            </div>
        </div>
    </div>
</div>
@endif

