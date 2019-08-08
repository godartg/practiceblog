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
        <form action="" id="imageInputForm">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post_id }}">

            <div id="actions">

                <fieldset class="docs-toggles">
                    <div class="d-block cropper-style-option">
                        <legend class="cropper-title">Tipo de recorte</legend>
                        <div class="row crop-style-container">
                            <div class="cropStyleItem activeRadio d-none" id="crop-style-item-d-none"></div>
                            <div class="col-md-3 text-center crop-style-item">
                                <label for="radio-libre">
                                    <input id="radio-libre" class="inputRadio" style="display: none;" type="radio" data-method="libre" name="clippingType">
                                    <i class="material-icons">crop</i>
                                    Libre
                                </label>
                            </div>
                            <div class="col-md-3 text-center crop-style-item">
                                <label for="radio-rectangular">
                                    <input id="radio-rectangular" class="inputRadio" style="display: none;" type="radio" data-method="rectangle" name="clippingType">
                                    <i class="material-icons">crop_5_4</i>
                                    Rectangular
                                </label>
                            </div>
                            <div class="col-md-3 text-center crop-style-item">
                                <label for="radio-cuadrado">
                                    <input id="radio-cuadrado" class="inputRadio" style="display: none;" type="radio" data-method="cuadrado" name="clippingType">
                                    <i class="material-icons">crop_square</i>
                                    Cuadrado
                                </label>
                            </div>
                            <div class="col-md-3 text-center crop-style-item">
                                <label for="radio-circular">
                                    <input id="radio-circular" class="inputRadio" style="display: none;" type="radio" data-method="circle" name="clippingType">
                                    <i class="material-icons">all_out</i>
                                    Circular
                                </label>
                            </div>  
                        </div>
                    </div>
                    <div class="d-block cropper-style-option">
                        <legend class="cropper-title">Dimensiones</legend>
                        <h5 class="d-inline">Alto: &nbsp;</h5>
                        <input type="number" id="dataHeight" min="1" max="2000" step="1" style="width: 45px;border: none; background: rgba(0,0,0,0);">
                        <p class="d-inline">px &nbsp;&nbsp;|</p>
                        <h5 class="d-inline">&nbsp;Ancho: &nbsp;</h5>
                        <input type="number" id="dataWidth" min="1" max="2000" step="1" style="width: 45px;border: none; background: rgba(0,0,0,0);">
                        <p class="d-inline">px</p>
                    </div>
                </fieldset>

                <fieldset class="docs-buttons cropper-style-option">
                    <legend class="cropper-title">Opciones</legend>
                    <button type="button" data-method="cancel" class="cropper-btn-secondary" id="btnCancel">Cancelar</button>
                    <div style="float: right;">
                        <button class="cropper-btn-primary" type="submit" id="btnSaveUpload">Subir</button>
                    </div>
                </fieldset>
                
                <fieldset class="docs-advanced">
                    <legend class="cropper-title">Información de imagen</legend>
                    <label for="activeAdvanced" class="switch">
                        <input type="checkbox" id="activeAdvanced">
                        <span id="activeAdvancedMessage" class="slider round"></span>
                    </label>
                </fieldset>

                <fieldset class="advanced d-none">
                    <legend class="cropper-title">Calidad de imagen</legend>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-sm-5">
                            <h5 class="d-inline">Calidad: &nbsp;</h5>
                            <input type="number" id="inputNumberCalidad" min="1" max="99" value="50" step="1" class="d-inline" style="">
                        </div>
                        <div class="col-sm-7">
                            <div class="inputDiv pull-right">
                                <input type="range" id="inputRangeCalidad"  min="1" max="99" value="50" class="d-inline">
                            </div>
                        </div>
                    </div>
                    
                    <div class="table">
                        <table border="0" cellspacing="0">
                            {{-- <thead>
                                <tr>
                                    <th>Característica</th>
                                    <th>Valor</th>
                                </tr>
                            </thead> --}}
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
            
            <div>
                <label class="cropper-btn-primary">
                    <input type="file" id="inputImage" name="inputImage" accept="image/*"/>
                    <i class="fa fa-picture-o"></i>
                    &nbsp; Selecciona una imagen
                </label>
                <a class="cropper-btn-secondary" href="{{ url()->previous() }}">
                    <i class="fa fa-times"></i>
                    &nbsp; Cancelar
                </a>
        
                
                <button id="btnGoBack" class="cropper-btn-secondary d-inline">
                    <i class="fa fa-refresh"></i>
                    &nbsp; Recargar
                </button>
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
	   var post_id = {!! $post_id !!};

       // let container = document.querySelector('.crop-style-container');
       // container.addEventListener('click', e => {
       //  if(e.target.classList.contains('crop-style-item')){
       //      console.log(e.target);
       //      console.log(e.target.classList.add("activeRadio"));
       //  }
       // })
       let cropStyleContainer = document.querySelector('.crop-style-container');

       let cropStyleItem = document.getElementsByClassName("crop-style-item");


       for (var i = 0; i < cropStyleItem.length; i++) {
          cropStyleItem[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("activeRadio");
            current[0].className = current[0].className.replace(" activeRadio", "");
            this.className += " activeRadio";
          });
        }

        let activeOption = document.getElementsByClassName(".activeRadio");
        let cropStyleItemDNone = document.getElementById('crop-style-item-d-none');
        let btnCancel = document.getElementById('btnCancel');
        let btnSaveUpload = document.getElementById('btnSaveUpload');


        btnCancel.addEventListener('click', function(){
            cancelaStyleActiveRadio();
        });

        btnSaveUpload.addEventListener('click', function(){
            cancelaStyleActiveRadio();
        });

        function cancelaStyleActiveRadio() {
            for (var i = 0; i < cropStyleItem.length; i++) {
              cropStyleItem[i].classList.remove("activeRadio");
            }
            cropStyleItemDNone.className += " activeRadio";
        }


	</script>
	<script src="/js/cropper-compress.js"></script>

@endpush