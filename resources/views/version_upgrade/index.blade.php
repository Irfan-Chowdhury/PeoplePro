@extends('layout.main')
@section('title','Admin | New Release Version')
@section('content')

    <div class="mt-3 mb-3" id="errorMessage"></div>

    <!-- Old Version -->
    @if (!$alertVersionUpgradeEnable)
        <section id="oldVersionSection" class="container mt-5 text-center">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('versionUpgrated') && session()->get('versionUpgrated')==='success')
                            <h2 class="text-center text-success"><strong>Congratulation !!!</strong> System updated successfully.</span></h2>
                        @endif
                        <h4 class="text-center text-info">Your current version is <span>{{env('VERSION')}}</span></h4>
                        <p>Please wait for upcoming version</p>
                    </div>
                </div>
        </section>
    @else
        <!-- For New Version -->
        <section id="newVersionSection" class="container mt-5 text-center">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center text-success">A new version <span id="newVersionNo"></span> has been released.</h4>
                    <p>Before upgrading, we highly recomended you to keep a backup of your current script and database.</p>
                </div>
            </div>

            <div class="card mt-3">
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

            <button id="upgrade" type="button" class="mt-5 mb-5 btn btn-primary btn-lg">Upgrade</button>
        </section>
    @endif
@endsection


@push('scripts')

<script>
    let clientCurrrentVersion = {!! json_encode(env("VERSION"))  !!};
    let clientCurrrentBugNo   = {!! json_encode(env("BUG_NO"))  !!};
    let versionUpgradeURL     = "{{route('version-upgrade')}}";
    let redirectURL           = "{{ route('new-release')}}";
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
<script type="text/javascript" src="{{asset('js/admin/version_upgrade/index.js')}}"></script>
@endpush
