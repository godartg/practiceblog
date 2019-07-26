@extends('admin.layout')


@section('header')

<h1>
POST
<small>Listado</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
	<li class="active">Posts</li>
</ol>

@stop

@section('content')

<div class="box box-primary">
<div class="box-header">
  <h3 class="box-title">Listado de publicaciones</h3>
  <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">
  	<i class="fa fa-plus"></i> Crear publicación</button>
</div>
<!-- /.box-header -->
<div class="box-body">
  <table id="posts-table" class="table table-bordered table-striped">
    <thead>
    <tr>
      <th>ID</th>
      <th>Título</th>
      <th>Extracto</th>
      <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
		@foreach($posts as $post)
			<tr>
				<td>{{ $post->id }}</td>
				<td>{{ $post->title }}</td>
				<td>{{ $post->excerpt }}</td>
				<td>
					<a href="{{ route('posts.show',$post) }}" target="_blank" class="btn btn-xs btn-info">
						<i class="fa fa-eye"></i>
					</a>
					<a href="{{ route('admin.posts.edit',$post) }}" class="btn btn-xs btn-info">
						<i class="fa fa-pencil"></i>
					</a>
					<form method="POST" action="{{ route('admin.posts.destroy',$post) }}" style="display: inline;">
						{{ csrf_field() }}  {{ method_field('DELETE') }}
						<button class="btn btn-xs btn-danger"
							onclick="return confirm('¿Estas seguro que deseas eliminar el post?')">
							<i class="fa fa-trash-o"></i>
						</button>
					</form>
				</td>
			</tr>
		@endforeach
    </tbody>
    
  </table>
  <div id="print_button_container">Imprimir</div>
</div>
<!-- /.box-body -->
</div>

@stop


@push('styles')
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="/adminlte/plugins/datepicker/datepicker3.css">
  <script src="https://www.google.com/cloudprint/client/cpgadget.js"></script>
  <script>
	window.onload = function() {
    var gadget = new cloudprint.Gadget();
    gadget.setPrintButton(
        cloudprint.Gadget.createDefaultPrintButton("print_button_container")); // div id to contain the button
    gadget.setPrintDocument("[document mimetype]", "[document title]", "[document content]", "[encoding] (optional)");
  	}
  </script>
	
@endpush
@push('scripts')
	
	<script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>

	<script>
	  $(function () {
	    $('#posts-table').DataTable({
	      "paging": true,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": true,
	      "info": true,
	      "autoWidth": false
	    });
	  });
	</script>
	
@endpush