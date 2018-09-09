@extends('admin.layout')


@section('header')

<h1>
USUARIOS
<small>Listado</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
	<li class="active">Usuarios</li>
</ol>

@stop

@section('content')

<div class="box box-primary">
<div class="box-header">
  <h3 class="box-title">Listado de usuarios</h3>
  <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#exampleModal">
  	<i class="fa fa-plus"></i> Crear usuario</button>
</div>
<!-- /.box-header -->
<div class="box-body">
  <table id="users-table" class="table table-bordered table-striped">
    <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Email</th>
      <th>Roles</th>
      <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
		@foreach($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->getRoleNames()->implode(', ') }}</td>
				<td>
					<a href="{{ route('admin.users.show',$user) }}" target="_blank" class="btn btn-xs btn-info">
						<i class="fa fa-eye"></i>
					</a>
					<a href="{{ route('admin.users.edit',$user) }}" class="btn btn-xs btn-info">
						<i class="fa fa-pencil"></i>
					</a>
					<form method="user" action="{{ route('admin.users.destroy',$user) }}" style="display: inline;">
						{{ csrf_field() }}  {{ method_field('DELETE') }}
						<button class="btn btn-xs btn-danger"
							onclick="return confirm('¿Estas seguro que deseas eliminar el user?')">
							<i class="fa fa-trash-o"></i>
						</button>
					</form>
				</td>
			</tr>
		@endforeach
    </tbody>
    
  </table>
</div>
<!-- /.box-body -->
</div>

@stop


@push('styles')
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="/adminlte/plugins/datepicker/datepicker3.css">

@endpush
@push('scripts')
	
	<script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>

	<script>
	  $(function () {
	    $('#users-table').DataTable({
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