@extends('layout.main')
@section('content')
@section('title','Admin | Developer Section')


<div class="container-fluid mb-3">
    <div class="row">
        <div class="col-4">
            <div class="card mb-0">
                <div id="collapse1" class="collapse show" aria-labelledby="generalSettings" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="auto-update-setting" data-toggle="list" href="#autoUpdateSetting" role="tab" aria-controls="home">@lang('file.Auto Update Setting')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8">

            @include('includes.session_message')

            <div class="tab-content" id="nav-tabContent">
                <!-- Auto Update -->
                <div class="tab-pane fade show active" id="autoUpdateSetting" role="tabpanel" aria-labelledby="auto-update-setting">
                    <div class="card">
                        <h4 class="card-header p-3"><b>@lang('file.Auto Update Setting')</b></h4>
                        <hr>
                        <div class="card-body">
                            <form action="{{ route('admin.developer-section.submit') }}" method="POST">
                                @csrf

                                <!----------------------------------- General ------------------------------------------>

                                <h5><b>@lang('General')</b></h5>
                                <hr>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Product Mode')</label>
                                    <div class="col-sm-8">
                                        <input type="text" readonly name="product_mode" class="form-control" value="{{env('PRODUCT_MODE')}}">
                                        <small class="text-danger">You have to change it from .env</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Version') <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" required name="version" class="form-control" value="{{env('VERSION')}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Bug No') <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" required name="bug_no" class="form-control" value="{{env('BUG_NO')}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Minimum Required Version') <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" required name="minimum_required_version" class="form-control" value="{{$general->minimum_required_version}}">
                                    </div>
                                </div>

                                <!----------------------------------- Version Upgrade ------------------------------------------>
                                <hr>
                                <h5><b>@lang('file.Version Upgrade')</b></h5>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Latest Version Upgrade')</label>
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                            <input type="checkbox" {{$control->version_upgrade->latest_version_upgrade_enable ? 'checked':''}} class="form-check-input" name="latest_version_upgrade_enable">
                                            <label class="form-check-label" for="exampleCheck1">Enable</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Latest Version DB Migrate')</label>
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                            <input type="checkbox" {{$control->version_upgrade->latest_version_db_migrate_enable ? 'checked':''}} class="form-check-input" name="latest_version_db_migrate_enable">
                                            <label class="form-check-label" for="exampleCheck1">Enable</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Version Upgrade URL') <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" required name="version_upgrade_base_url" class="form-control" value="{{$control->version_upgrade->version_upgrade_base_url}}" placeholder="Ex: https://cartproshop.com/version_upgrade_files/">
                                    </div>
                                </div>

                                <!----------------------------------- Bug Update ------------------------------------------>

                                <hr>
                                <h5><b>@lang('file.Bug Update')</b></h5>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Bug Update')</label>
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                            <input type="checkbox" {{$control->bug_update->bug_update_enable ? 'checked':''}} class="form-check-input" name="bug_update_enable">
                                            <label class="form-check-label" for="exampleCheck1">Enable</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Bug DB Migrate')</label>
                                    <div class="col-sm-8">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" {{$control->bug_update->bug_db_migrate_enable ? 'checked':''}} name="bug_db_migrate_enable">
                                            <label class="form-check-label" for="exampleCheck1">Enable</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">@lang('file.Bug Update URL') <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" required name="bug_update_base_url" class="form-control" value="{{$control->bug_update->bug_update_base_url}}" placeholder="Ex: https://cartproshop.com/bug_update_files/">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">@lang('file.Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
