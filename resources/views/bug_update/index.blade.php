@extends('layout.main')
@section('title','Admin | Bugs')
@section('content')

    <div class="mt-3 mb-3" id="errorMessage"></div>


    <!-- Old Version -->
    {{-- <section id="noBug" class="d-none container mt-5 text-center"> --}}
    <section id="noBug" class="container mt-5 text-center">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center text-info">Your current version is <span>{{config('auto_update.version')}}</span></h4>
                <p>There is no bug</p>
            </div>
        </div>
    </section>

    <!-- For New Version -->
    <section id="bugSection" class="d-none container mt-5 text-center">
    {{-- <section id="bugSection" class="container mt-5 text-center"> --}}
        <div class="card">
            <div class="card-body">
                <h4 class="text-center text-success">Minor bug found. Please update it.</h4>
                <p>Before updating, we highly recomended you to keep a backup of your current script and database.</p>
            </div>
        </div>

        <div id="changeLog" class="d-none card mt-3">
            <div class="card-body">
                <h6 class="text-left p-4">New Change Log</h6>
                <ul class="list-group text-left" id="logUL">
                </ul>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-3 mb-3">
            <div id="spinner" class="d-none spinner-border text-success" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <button id="update" type="button" class="mt-5 mb-5 btn btn-primary btn-lg">Update</button>
    </section>
@endsection


@push('scripts')

<script>
    let clientCurrrentVersion = {!! json_encode(env("VERSION"))  !!};
    let clientCurrrentBugNo   = {!! json_encode(env("BUG_NO"))  !!};
    let bugUpdateURL          = "{{ route('bug-update') }}";
    let redirectURL           = "{{ route('admin.dashboard') }}";
</script>

<script type='text/javascript'>
    (function() {
        if( window.localStorage ) {
            if( !localStorage.getItem('firstLoad') ) {
                localStorage['firstLoad'] = true;
                window.location.reload();
            }
            else {
                localStorage.removeItem('firstLoad');
            }
        }
    })();
</script>

<script type="text/javascript">
    (function ($) {
        "use strict";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })(jQuery);
</script>
<script type="text/javascript" src="{{asset('js/admin/bug_update/index.js')}}"></script>
@endpush
