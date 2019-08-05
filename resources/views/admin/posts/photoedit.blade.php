@extends('admin.layout')
@section('header')
<h2 style="text-align: center; color: #1A73E8;font-weight: bold; font-family: Helvetica; font-size: 16px;">CROPPER-COMPRESS</h2>

@stop

@section('content')
<div class="row containerCropperCompress">
    <div class="col-md-8" id="containerImage">
        <img id="source_image" crossorigin="anonymous" src="">
        <img id="result_image" style="display: none;" crossorigin="anonymous" src="">
    </div>
    <div class="col-md-4">
        <form action="{{route('admin.drive.create')}}" id="imageInputForm">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post_id }}">
            <input type="file" id="inputImage" accept="image/*" />
            <button id="btnGoBack">Recargar</button>
            <div id="actions">

                <fieldset class="docs-toggles">
                    <div class="d-block">
                        <legend>Tipo de recorte</legend>
                        <label>
                            <input type="radio" data-method="libre" name="clippingType">
                            <span>Libre</span>
                        </label>
                        <label>
                            <input type="radio" data-method="rectangle" name="clippingType">
                            <span>Rectangular</span>
                        </label>
                        <label>
                            <input type="radio" data-method="cuadrado" name="clippingType">
                            <span>Cuadrado</span>
                        </label>
                        <label>
                            <input type="radio" data-method="circle" name="clippingType">
                            <span>Circular</span>
                        </label>
                    </div>
                    <div class="d-block">
                        <h5 class="d-inline">Alto</h5>
                        <input type="number" id="dataHeight" min="1" max="2000" step="1" style="width: 60px;">
                        <p class="d-inline">px &nbsp;&nbsp;|</p>
                        <h5 class="d-inline">&nbsp;Ancho</h5>
                        <input type="number" id="dataWidth" min="1" max="2000" step="1" style="width: 60px;">
                        <p class="d-inline">px</p>
                    </div>
                </fieldset>

                <fieldset class="docs-buttons">
                    <legend>Opciones</legend>
                    <button type="button" data-method="cancel" id="btnCancel">Cancelar</button>
                    <div style="float: right;">
                        <button type="submit" id="btnSaveUpload">Subir</button>
                    </div>
                </fieldset>
                
                <fieldset class="docs-advanced">
                    <legend>Información de imagen</legend>
                    <label for="activeAdvanced" class="switch">
                        <input type="checkbox" id="activeAdvanced">
                        <span id="activeAdvancedMessage" class="slider round"></span>
                    </label>
                </fieldset>

                <fieldset class="advanced d-none">
                    <legend>Calidad de imagen</legend>
                    <h5 class="d-inline">Calidad</h5>
                    <input type="number" id="inputNumberCalidad" min="1" max="99" value="50" step="1" style="width: 60px;">
                    <input type="range" id="inputRangeCalidad"  min="1" max="99" value="50">
                    
                    <div class="table">
                        <h5 style="size: 15px; margin-top: 0; margin-bottom: 10px;">Opciones avanzadas</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Característica</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Peso inicial</td>
                                    <td id="pesoInicial"></td>
                                </tr>
                                <tr>
                                    <td>Peso final</td>
                                    <td id="pesoFinal"></td>
                                </tr>
                                <tr>
                                    <td>% Peso reducido</td>
                                    <td id="quality"></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                    </div>
                </fieldset>
            </div>
        </form>    
    </div>
</div>

@stop

@push('styles')
    <!-- styles -->
	<!-- cropperjs -->
    <link rel="stylesheet" href="/css/cropper.min.css">
    <!-- cropper-compress -->
    <link rel="stylesheet" href="/css/cropper-compress.css">
@endpush

@push('scripts')
<!-- scripts -->
	<!-- cropper.js -->
	<script src="/js/cropper.min.js"></script>
	<!-- JIC.js -->
	<script src="/js/JIC.min.js"></script>
	<!-- browser-image-compression -->
	<script src="/js/browser-image-compression.js"></script>
	<!-- axios v0.19.0 -->
	<script src="/js/axios.min.js"></script>
	<!-- cropper-compress.js -->
	<script>
			
	var post_id = {!! $post_id !!}

	</script>
	<script src="/js/cropper-compress.js"></script>

@endpush