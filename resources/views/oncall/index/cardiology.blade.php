@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-md-12 mb-2">
        <div class="card card-custom gutter-b" style="border-radius: 0px !important; background-color: #FFF0F5;">
            <div class="row m-3">
                <div class="col-md-12">
                    <h4 style="padding: 0.5rem !important; margin-bottom: 0px !important; color: #0f0f0f; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <span>•</span> ON CALL ASSIGNMENT<span>•</span>
                    </h4>
                </div>
            </div>
        </div>
        <br/>
        <div class="card-body">
            @include('oncall.calendar.cardiology')
        </div>
    </div>
</div>
<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>
@include('oncall.form.create.cardiology')
@include('oncall.form.edit.cardiology')

@endsection

@push('script')
    <script src="{{ asset('js/oncall/cardiology.js') }}"></script>
    <script>
        var config = {
                routes: {
                    oncallassignment :{
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