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
            @include('oncall.calendar.other')
        </div>
    </div>
</div>
<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>
@include('oncall.form.create.other')
@include('oncall.form.edit.other')

@endsection

@push('script')
    <script src="{{ asset('js/oncall/other.js') }}"></script>
    <script>
        var config = {
                routes: {
                    oncallassignment :{
                        other : {
                            save        : "{{ route('ocassignment.other.save') }}",
                            getlist     : "{{ route('ocassignment.other.get') }}",
                            update      : "{{ route('ocassignment.other.update') }}",
                        },
                    }       
                }
            };
    </script>
@endpush