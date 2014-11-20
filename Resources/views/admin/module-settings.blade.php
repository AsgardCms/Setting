@extends('core::layouts.master')

@section('content-header')
<h1>
    {{ trans('setting::settings.title.module name settings', ['module' => ucfirst($currentModule)]) }}
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('dashboard.setting.index') }}"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.settings') }}</a></li>
    <li class="active"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.module settings', ['module' => ucfirst($currentModule)]) }}</li>
</ol>
@stop

@section('styles')
<link href="{!! Module::asset('core:css/vendor/iCheck/flat/blue.css') !!}" rel="stylesheet" type="text/css" />
@stop

@section('content')
{!! Form::open(['route' => ['dashboard.setting.store'], 'method' => 'post']) !!}
<div class="row">
    <div class="sidebar-nav col-sm-2">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{ trans('setting::settings.title.module settings') }}</h3>
            </div>
            <style>
                a.active {
                    text-decoration: none;
                    background-color: #eee;
                }
            </style>
    		<ul class="nav nav-list">
    		  <?php foreach($modulesWithSettings as $module => $settings): ?>
                  <li>
                    <a href="{{ URL::route('dashboard.module.settings', [$module]) }}" class="{{ $module == ucfirst($currentModule) ? 'active' : '' }}">
                        {{ $module }}
                        <small class="badge pull-right bg-blue">{{ count($settings) }}</small>
                    </a>
                    </li>
              <?php endforeach; ?>
    		</ul>
    	</div>
    </div>
    <div class="col-md-10">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{ trans('core::core.title.translatable fields') }}</h3>
            </div>
            <?php if ($translatableSettings): ?>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    @include('core::partials.form-tab-headers')
                    <div class="tab-content">
                        <?php $i = 0; ?>
                        <?php foreach(LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                            <?php $i++; ?>
                            <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                @include('setting::admin.partials.fields', ['settings' => $translatableSettings])
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($plainSettings): ?>
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{ trans('core::core.title.non translatable fields') }}</h3>
            </div>
            <div class="box-body">
                @include('setting::admin.partials.fields', ['settings' => $plainSettings])
            </div>
        </div>
        <?php endif; ?>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
            <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('dashboard.setting.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop

@section('scripts')
<script>
$( document ).ready(function() {
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('input[type="checkbox"]').on('ifChecked', function(){
      $(this).parent().find('input[type=hidden]').remove();
    });

    $('input[type="checkbox"]').on('ifUnchecked', function(){
      var name = $(this).attr('name'),
          input = '<input type="hidden" name="' + name + '" value="0" />';
      $(this).parent().append(input);
    });
});
</script>
@stop
