@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-12 mb-2">
        <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #FFF0F5;">
            <div class="row m-3">
                <div class="col-md-12">
                    <h4 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: #0f0f0f; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <span>•</span> On Call Assignment <span>•</span>
                    </h4>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            <div class="mb-5 hover-scroll-x">
                <div class="d-grid">
                    <ul class="nav nav-tabs flex-nowrap text-nowrap">
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link active btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#cardiothoracic">CARDIOTHORACIC</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#cardiology">CARDIOLOGY</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#nursemanager">NURSE MANAGER</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#anaes">ANAESTHESIA</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#perfusionist">PEFUSIONIST</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#pchc">PCHC</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#cvt">CVT</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#dietitian">DIETITIAN</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#physio">PHYSIOTHERAPIST</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="cardiothoracic" role="tabpanel">
                    @include('oncall.calendar.cardiothoracic')
                </div>
                <div class="tab-pane fade show" id="cardiology" role="tabpanel">
                    @include('oncall.calendar.cardiology')
                </div>
            </div>
        </div>
    </div>
</div>

@include('oncall.form.create.cardiothoracic')
@include('oncall.form.edit.cardiothoracic')
@include('oncall.form.create.cardiology')
@include('oncall.form.edit.cardiology')

@push('script')
    <script>
        var config = {
                routes: {
                    oncallassignment :{
                        cardiothoracic : {
                            save        : "{{ route('ocassignment.ct.save') }}",
                            getlist     : "{{ route('ocassignment.ct.get') }}",
                            update      : "{{ route('ocassignment.ct.update') }}",
                        }, 
                        cardiology : {
                            save        : "{{ route('ocassignment.cd.save') }}",
                            getlist     : "{{ route('ocassignment.cd.get') }}",
                            update      : "{{ route('ocassignment.cd.update') }}",
                        },
                    }       
                }
            };
    </script>
@endpush

@endsection