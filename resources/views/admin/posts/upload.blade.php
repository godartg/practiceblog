@if (Auth::user()->refresh_token != '')
<div class="col-md-4">
    <div class="box box-primary">
        <div class="box-body">
            <div class="form-group">
                <label>Agregar imágenes</label>
                <form action="{{route('admin.drive.create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post_id }}">
                    <label for="file">subir imagen</label>
                    <input type="submit" class="btn btn-primary btn-block" value="Submit">
                    <input type="file" name="file" id="fileFormatImage">
                    {{--<a href="{{ route('admin.photos.edit',$post_id) }}" class="btn btn-primary btn-block">Nueva imagen</a>--}}
                </form>
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

@push('scripts')
<!-- scripts -->
    <script>
        // obtiene input format
        var fileFormatImage = document.getElementById('fileFormatImage').onchange = function (e) {
            let files = this.files;
            console.log(files);
        }

        var data = new FormData();
        console.log(data);

    </script>

@endpush

