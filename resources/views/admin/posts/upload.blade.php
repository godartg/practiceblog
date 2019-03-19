@if (Auth::user()->refresh_token != '')
<div class="form-group">
    
    <form action="{{route('admin.drive.create')}}" method="post" enctype="multipart/form-data">
        @csrf
        
        <input type="file" name="file">
        <input type="submit" value="Submit">
    </form>
</div>
@else
	<div class="form-group">
	    <a class="btn btn-success" href="{{route('login.google')}}">Agregar Cuenta Drive</a>
	</div>
@endif

