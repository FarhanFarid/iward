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
            @include('oncall.calendar.staffassignment')
        </div>
    </div>
</div>
<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>
@include('oncall.form.create.staffassignment')
@include('oncall.form.edit.staffassignment')

@endsection

@push('script')
    <script src="{{ asset('js/oncall/staffassignment.js') }}"></script>
    <script>
        var config = {
                routes: {
                    oncallassignment :{
                        sa : {
                            save        : "{{ route('ocassignment.sa.save') }}",
                            getlist     : "{{ route('ocassignment.sa.get') }}",
                            update      : "{{ route('ocassignment.sa.update') }}",
                        },
                    }       
                }
            };
    </script>
@endpush