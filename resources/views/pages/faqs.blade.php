@extends('layouts.template')

@section('cssstyles')
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('body')
<div class="content-wrapper">

    <!-- HEADER -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Gestión de Preguntas Frecuentes (FAQs)</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- CATEGORÍAS DE FAQ -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Categorías de Preguntas</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addFaqCategoryRow()">
                        <i class="fa fa-plus mr-1"></i> Nueva Categoría
                    </button>
                </div>

                <div class="card-body" id="faq-category-list">
                    @foreach($categories->sortBy('order_num') as $cat)
                    <div class="row align-items-center mb-3 border-bottom pb-2 faq-category-row" data-id="{{ $cat->id }}">
                        <div class="col-sm-3">
                            <label>Nombre</label>
                            <input type="text" name="faqcat_name_{{ $cat->id }}" value="{{ $cat->name }}" class="form-control" placeholder="Ej: Pedido, Envío...">
                        </div>

                        <div class="col-sm-3">
                            <label>Clase del ícono (FontAwesome / MDI)</label>
                            <input type="text" name="faqcat_icon_{{ $cat->id }}" value="{{ $cat->icon_class }}" class="form-control" placeholder="mdi mdi-help-circle" oninput="previewFaqIcon(this)">
                            <div class="icon-preview mt-2" style="font-size:1.4rem;">
                                <i class="{{ $cat->icon_class }}"></i>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <label>Orden</label>
                            <input type="number" name="faqcat_order_{{ $cat->id }}" value="{{ $cat->order_num }}" class="form-control" min="0">
                        </div>

                        <div class="col-sm-2 d-flex align-items-center mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="faqcat_active_{{ $cat->id }}" {{ $cat->is_active ? 'checked' : '' }}>
                                <label class="form-check-label">Activo</label>
                            </div>
                        </div>

                        <div class="col-sm-2 d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-sm btn-primary mr-1" onclick="updateFaqCategory({{ $cat->id }})">
                                <i class="fa fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteFaqCategory({{ $cat->id }})">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


            <!-- PREGUNTAS POR CATEGORÍA -->
            <div class="card card-warning">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Preguntas y Respuestas</h3>
                    <button type="button" class="btn btn-sm btn-success" onclick="addFaqRow()">
                        <i class="fa fa-plus mr-1"></i> Nueva Pregunta
                    </button>
                </div>

                <div class="card-body" id="faq-list">
                    @foreach($categories as $cat)
                        <h5 class="text-primary mt-4 mb-2">
                            <i class="{{ $cat->icon_class }}"></i> {{ $cat->name }}
                        </h5>

                        @foreach($cat->faqs as $faq)
                        <div class="row align-items-start mb-3 border-bottom pb-2 faq-row" data-id="{{ $faq->id }}">
                            <div class="col-sm-4">
                                <label>Pregunta</label>
                                <input type="text" name="faq_question_{{ $faq->id }}" value="{{ $faq->question }}" class="form-control" placeholder="¿Cuál es el tiempo de entrega?">
                            </div>
                            <div class="col-sm-6">
                                <label>Respuesta</label>
                                <textarea name="faq_answer_{{ $faq->id }}" class="form-control" rows="2" placeholder="Texto de la respuesta...">{{ $faq->answer }}</textarea>
                            </div>
                            <div class="col-sm-1">
                                <label>Orden</label>
                                <input type="number" name="faq_order_{{ $faq->id }}" value="{{ $faq->order_num }}" class="form-control" min="0">
                            </div>
                            <div class="col-sm-1 d-flex align-items-center mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="faq_active_{{ $faq->id }}" {{ $faq->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">Activo</label>
                                </div>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-sm btn-primary mr-1" onclick="updateFaq({{ $faq->id }})">
                                    <i class="fa fa-save"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteFaq({{ $faq->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

        </div>
    </section>
</div>

<!-- Scripts base -->
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.js"></script>
<script src="/template/dist/js/adminlte.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JS del módulo de FAQs -->
<script src="/template/dist/js/page_faqs.js"></script>

<script>
$(function(){ bsCustomFileInput.init(); });

function previewFaqIcon(input) {
    const icon = $(input).val();
    const container = $(input).siblings('.icon-preview');
    container.html(`<i class="${icon}"></i>`);
}
</script>
@endsection
