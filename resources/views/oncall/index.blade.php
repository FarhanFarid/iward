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
            <div class="mb-5 hover-scroll-x">
                <div class="d-grid">
                    <ul class="nav nav-tabs flex-nowrap text-nowrap">
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link active btn btn-light-primary btn-active-primary btn-color-light-primary btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#cardiothoracic">CARDIOTHORACIC</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-primary btn-active-primary btn-color-light-primary btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#cardiology">CARDIOLOGY</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-primary btn-active-primary btn-color-light-primary btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#anaes">ANAESTHESIA</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-primary btn-active-primary btn-color-light-primary btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#pchc">PCHC</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#nursemanager">NURSE MANAGER</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#other">OTHERS</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#ert">EMERGENCY RESPONSE TEAM</a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px;">
                            <a class="nav-link btn btn-light-success btn-active-success btn-color-light-success btn-active-color-light rounded-bottom-0" data-bs-toggle="tab" href="#sa">STAFF ASSIGNMENT</a>
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
                <div class="tab-pane fade show" id="nursemanager" role="tabpanel">
                    @include('oncall.calendar.nursemanager')
                </div>
                <div class="tab-pane fade show" id="anaes" role="tabpanel">
                    @include('oncall.calendar.anaesthesia')
                </div>
                <div class="tab-pane fade show" id="pchc" role="tabpanel">
                    @include('oncall.calendar.pchc')
                </div>
                <div class="tab-pane fade show" id="other" role="tabpanel">
                    @include('oncall.calendar.other')
                </div>
                <div class="tab-pane fade show" id="ert" role="tabpanel">
                    @include('oncall.calendar.ert')
                </div>
                <div class="tab-pane fade show" id="sa" role="tabpanel">
                    @include('oncall.calendar.staffassignment')
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loading-overlay">
    <div class="loading-icon"></div>
</div>
@include('oncall.form.create.cardiothoracic')
@include('oncall.form.edit.cardiothoracic')
@include('oncall.form.create.cardiology')
@include('oncall.form.edit.cardiology')
@include('oncall.form.create.nursemanager')
@include('oncall.form.edit.nursemanager')
@include('oncall.form.create.anaesthesia')
@include('oncall.form.edit.anaesthesia')
@include('oncall.form.create.pchc')
@include('oncall.form.edit.pchc')
@include('oncall.form.create.other')
@include('oncall.form.edit.other')
@include('oncall.form.create.ert')
@include('oncall.form.edit.ert')
@include('oncall.form.create.staffassignment')
@include('oncall.form.edit.staffassignment')

@endsection

@push('script')
    {{-- <script src="{{ asset('js/oncall/calendar.js') }}"></script> --}}
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
                        nursemanager : {
                            save        : "{{ route('ocassignment.nm.save') }}",
                            getlist     : "{{ route('ocassignment.nm.get') }}",
                            update      : "{{ route('ocassignment.nm.update') }}",
                        },
                        anaes : {
                            save        : "{{ route('ocassignment.anaes.save') }}",
                            getlist     : "{{ route('ocassignment.anaes.get') }}",
                            update      : "{{ route('ocassignment.anaes.update') }}",
                        },
                        pchc : {
                            save        : "{{ route('ocassignment.pchc.save') }}",
                            getlist     : "{{ route('ocassignment.pchc.get') }}",
                            update      : "{{ route('ocassignment.pchc.update') }}",
                        },
                        other : {
                            save        : "{{ route('ocassignment.other.save') }}",
                            getlist     : "{{ route('ocassignment.other.get') }}",
                            update      : "{{ route('ocassignment.other.update') }}",
                        },
                        ert : {
                            save        : "{{ route('ocassignment.ert.save') }}",
                            getlist     : "{{ route('ocassignment.ert.get') }}",
                            update      : "{{ route('ocassignment.ert.update') }}",
                        },
                        sa : {
                            save        : "{{ route('ocassignment.sa.save') }}",
                            getlist     : "{{ route('ocassignment.sa.get') }}",
                            update      : "{{ route('ocassignment.sa.update') }}",
                        },
                    }       
                }
            };


        const tabScripts = {
            cardiothoracic: {
                loaded: false,
                src: '{{ asset("js/oncall/cardiothoracic.js") }}',
                init: 'initCardiothoracicTab'
            },
            cardiology: {
                loaded: false,
                src: '{{ asset("js/oncall/cardiology.js") }}',
                init: 'initCardiologyTab'
            },
            anaes: {
                loaded: false,
                src: '{{ asset("js/oncall/anaesthesia.js") }}',
                init: 'initAnaesTab'
            },
            nursemanager: {
                loaded: false,
                src: '{{ asset("js/oncall/nursemanager.js") }}',
                init: 'initNursemanagerTab'
            },
            pchc: {
                loaded: false,
                src: '{{ asset("js/oncall/pchc.js") }}',
                init: 'initPchcTab'
            },
            other: {
                loaded: false,
                src: '{{ asset("js/oncall/other.js") }}',
                init: 'initOtherTab'
            },
            ert: {
                loaded: false,
                src: '{{ asset("js/oncall/ert.js") }}',
                init: 'initErtTab'
            },
            sa: {
                loaded: false,
                src: '{{ asset("js/oncall/staffassignment.js") }}',
                init: 'initSaTab'
            }
        };


        function loadScript(tabId) {
            const tab = tabScripts[tabId];
            if (!tab) {
                console.warn('No script config for tab:', tabId);
                return;
            }
            if (tab.loaded) {
                console.log(`Script for tab "${tabId}" already loaded.`);
                if (typeof window[tab.init] === 'function') {
                    window[tab.init]();
                }
                return;
            }

            console.log(`Loading script for tab "${tabId}" from:`, tab.src);
            const script = document.createElement('script');
            script.src = tab.src;
            script.onload = () => {
                tab.loaded = true;
                console.log(`Script loaded: ${tab.src}`);
                if (typeof window[tab.init] === 'function') {
                    window[tab.init]();
                } else {
                    console.error(`Init function ${tab.init} not found on window object.`);
                }
            };
            script.onerror = () => {
                console.error(`Failed to load script for tab "${tabId}"`);
            };
            document.body.appendChild(script);
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadScript('cardiothoracic'); // default tab
        });

        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(el => {
            el.addEventListener('shown.bs.tab', function (e) {
                const tabId = e.target.getAttribute('href').replace('#', '');
                loadScript(tabId);
            });
        });
    </script>
@endpush