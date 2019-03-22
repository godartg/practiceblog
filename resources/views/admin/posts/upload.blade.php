@if (Auth::user()->refresh_token != '')
<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group">
                <form action="{{route('admin.drive.create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post_id }}">
                    <input type="file" name="file">
                    <input type="submit" value="Submit">
                </form>
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

