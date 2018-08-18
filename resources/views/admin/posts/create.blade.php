@extends('admin.layout')

@section('header')

<h1>
	POST
		<small>Crear publicacion</small>
</h1>
<ol class="breadcrumb">
	<li><a href="{{ route('dashboard') }}"></i> Inicio</a></li>
	<li><a href="{{ route('admin.posts.index') }}">Posts</a></li>
	<li class="active">Crear</li>
</ol>

@stop

@section('content')

<div class="row">
	<form action="">
	<div class="col-md-8">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group">
					<label>Título de la publicación</label>
					<input name="title" type="text" class="form-control" placeholder="Titulo de la publicación">
				</div>
				<div class="form-group">
					<label>Cuerpo de la publicación</label>
					<textarea id="editor" rows="10" name="bldy" class="form-control" placeholder="Ingresa el contenido completo de la publicación"></textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group">
	                <label>Fecha de pulblicación</label>

	                <div class="input-group date">
	                  <div class="input-group-addon">
	                    <i class="fa fa-calendar"></i>
	                  </div>
	                  <input type="text" name="published_at" class="form-control pull-right" id="datepicker">
	                </div>
              	</div>

              	<div class="form-group">
              		<label>Categorías</label>
              		<select name="" class="form-control">
              			@foreach($categorias as $category)
              				<option value="{{ $category->id }}">{{ $category->name }}</option>
              			@endforeach
              		</select>
              	</div>

              	<div class="form-group">
              		<label>Etiquetas</label>
              		<select class="form-control select2" 
              			multiple="multiple" 
              			data-placeholder="Selecciona una etiqueta" 
              			style="width: 100%;">
		                  @foreach($tags as $tag)
		                  	<option value="{{ $tag->id }}"> {{ $tag->name }}</option>
		                  @endforeach
	                </select>
              	</div>

				<div class="form-group">
					<label>Extracto de la publicación</label>

					<textarea name="excerpt" class="form-control" placeholder="Ingresa un extracto o resumen de la publicación"></textarea>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>
@stop

@push('styles')

  <!-- Select2 -->
  <link rel="stylesheet" href="/adminlte/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="/adminlte/plugins/datatables/dataTables.bootstrap.css">

@endpush
@push('scripts')

	<!-- Select2 -->
	<script src="/adminlte/plugins/select2/select2.full.min.js"></script>
	<!-- CK Editor -->
	<script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
	{{-- DatePicker --}}
	<script src="/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script>
		//Date picker
		$('#datepicker').datepicker({
		  autoclose: true
		});
		$(function () {
		    // Replace the <textarea id="editor1"> with a CKEditor
		    // instance, using default configuration.
		    CKEDITOR.replace('editor');
		    //bootstrap WYSIHTML5 - text editor
		    $(".textarea").wysihtml5();
		});
		// Inicializacion de select2 multiple
		$(".select2").select2();
</script>
@endpush
