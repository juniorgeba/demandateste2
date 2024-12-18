@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <div class="content">
        <div
            class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-start">
            <div>
                <h1 class="h3 mb-1">
                    Medidas
                </h1>
                <p class="fw-medium mb-0 text-muted">
                    Medidas Socioeducativas.
                </p>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Overview -->
        <div class="row items-push">
            @foreach($medidasPorStatus as $medida)
                <div class="col-sm-6 col-xl-3">
                    <div class="block block-rounded text-center d-flex flex-column h-100 mb-0">
                        <div class="block-content block-content-full flex-grow-1">
                            <div class="item rounded-3 bg-body mx-auto my-3">
                                <i class="fa fa-users fa-lg text-primary"></i>
                            </div>
                            <div class="fs-1 fw-bold">{{ $medida->total }}</div>
                            <div class="text-muted mb-3">{{ ucfirst($medida->status) }}</div>
                            {{--<div class="d-inline-block px-3 py-1 rounded-pill fs-sm fw-semibold text-info bg-info-light">
                                <i class="fa fa-info-circle me-1"></i>
                            </div>--}}
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                            <a class="fw-medium" href="{{ route('medidas.index', ['status' => $medida->status]) }}">
                                Ver todas as medidas
                                <i class="fa fa-arrow-right ms-1 opacity-25"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- END Overview -->
    </div>
    <!-- END Page Content -->
@endsection
