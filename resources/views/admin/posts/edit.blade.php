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
	@if ($post->photos->count())
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-body">
					<div class="row">
						@foreach ($post->photos as $photo)
						<form method="POST" action="{{ route('admin.photos.destroy',$photo) }}">
							{{ method_field('DELETE') }}  {{ csrf_field() }}
	 						<div class="col-md-2">
								<button class="btn btn-xs btn-danger" style="position: absolute;">
									<i class="fa fa-remove"></i>
								</button>
								<img class="img-responsive" src="/storage/{{ $photo->url }}">
							</div>
						</form>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	@endif
	<form method="POST" action="{{ route('admin.posts.update',$post) }}">

	@csrf @method('PUT')
	
	<div class="col-md-8">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group {{ $errors->has('title')? 'has-error': '' }} ">
					<label>Título de la publicación</label>
					<input 
						name="title" 
						type="text" 
						class="form-control" 
						value="{{ old('title',$post->title) }}" 
						placeholder="Titulo de la publicación">
					{!! $errors->first('title','<span class="help-block">:message</span>') !!}
				</div>

				<div class="form-group {{ $errors->has('body')? 'has-error': '' }}">
					<label>Cuerpo de la publicación</label>
					<textarea id="editor" class="md-textarea form-control" rows="10" name="body" placeholder="Ingresa el contenido completo de la publicación">{{ old('body',$post->body) }}</textarea>
					{!! $errors->first('body','<span class="help-block">:message</span>') !!}
				</div>

				<div class="form-group {{ $errors->has('iframe')? 'has-error': '' }}">
					<label>Contenido embebido iframe</label>
					<textarea id="editor" class="md-textarea form-control" rows="2" name="iframe" placeholder="Ingresa contenido embebido de audio y video (iframe)">{{ old('iframe',$post->iframe) }}</textarea>
					{!! $errors->first('iframe','<span class="help-block">:message</span>') !!}
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-body">
				<div class="form-group">
	                <label>Fecha de publicación</label>

	                <div class="input-group date">
	                  <div class="input-group-addon">
	                    <i class="fa fa-calendar"></i>
	                  </div>
	                  <input 
		                  type="text" 
		                  name="published_at" 
		                  class="form-control pull-right" 
		                  value="{{ old('published_at',$post->published_at ? $post->published_at->format('m/d/Y') : null) }}" 
		                  id="datepicker">
	                </div>
              	</div>

              	<div class="form-group {{ $errors->has('category_id')? 'has-error': '' }}">
              		<label>Categorías</label>
              		<select name="category_id" class="form-control select2">
              				<option value="">Seleccione una categoría</option>
              			@foreach($categories as $category)
              				<option value="{{ $category->id }}"
              						{{ old('category_id',isset($post->category->id)) == $category->id ? 'selected' : '' }}>
              					{{ $category->name }}
              				</option>
              			@endforeach
              		</select>
              		{!! $errors->first('category_id','<span class="help-block">:message</span>') !!}
              	</div>

              	<div class="form-group {{ $errors->has('etiquetas')? 'has-error': '' }}">
              		<label>Etiquetas</label>
              		<select name="tags[]" class="form-control select2" 
              			multiple="multiple" 
              			data-placeholder="Selecciona una o mas etiquetas" 
              			style="width: 100%;">
		                @foreach($tags as $tag)
		                  	<option {{ collect(old('tags',$post->tags->pluck('id')))->contains($tag->id) ? 'selected' : '' }} value="{{ $tag->id }}"> 
		                  		{{ $tag->name }}
		                  	</option>
		                @endforeach
	                </select>
	                {!! $errors->first('tags','<span class="help-block">:message</span>') !!}
              	</div>
				
				<div class="form-group {{ $errors->has('excerpt')? 'has-error': '' }}">
					<label>Extracto de la publicación</label>
					<textarea 
						name="excerpt" 
						class="md-textarea form-control" 
						placeholder="Ingresa un extracto o resumen de la publicación">{{ old('excerpt',$post->excerpt) }}</textarea>
					{!! $errors->first('excerpt','<span class="help-block">:message</span>') !!}
				</div>
				<div class="form-group">
					<div class="dropzone"></div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Guardar publicación</button>
				</div>
			</div>
		</div>
	</div>
	</form>
	@include('admin.posts.upload', ['post_id'=>$post->id])
</div>
@stop

@push('styles')
	<link rel="stylesheet" href="/adminlte/plugins/select2/select2.min.css">
	<link rel="stylesheet" href="/adminlte/plugins/datepicker/datepicker3.css">
  	<link rel="stylesheet" href="/adminlte/plugins/datatables/dataTables.bootstrap.css">

@endpush
@push('scripts')
	<script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>
	<script src="/adminlte/plugins/select2/select2.full.min.js"></script>
	<script src="/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
	
	<script>
		$('#datepicker').datepicker({
		  autoclose: true
		});

		$(".select2").select2({
			tags:true,
		});

		CKEDITOR.replace('editor');

		CKEDITOR.config.height = 315;
		
		
	</script>
@endpush
