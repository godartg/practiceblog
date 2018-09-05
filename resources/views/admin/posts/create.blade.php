<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form method="POST" action="{{ route('admin.posts.store','#create') }}">
		@csrf 
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Crear nueva publicación</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group {{ $errors->has('title')? 'has-error': '' }} ">
						{{-- <label>Título de la publicación</label> --}}
						<input 
						name="title" 
						id="post-title" 
						type="text" 
						class="form-control" 
						value="{{ old('title') }}" 
						placeholder="Titulo de la publicación" autofocus required>
						{!! $errors->first('title','<span class="help-block">:message</span>') !!}
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button class="btn btn-primary">Crear publicación</button>
				</div>
			</div>
		</div>
	</form>
</div>

@push('scripts')
	<script>
      if(window.location.hash === '#create'){
        $('#exampleModal').modal('show');
      }
      $('#exampleModal').on('hide.bs.modal',function(){
        window.location.hash = '#';
      });
       $('#exampleModal').on('shown.bs.modal',function(){
        $('#post-title').focus();
        window.location.hash = '#create';
      });
  </script>
@endpush