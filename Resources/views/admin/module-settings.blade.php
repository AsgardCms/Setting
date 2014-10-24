@extends('core::layouts.master')

@section('content-header')
<h1>
    {{ trans('setting::settings.title.module name settings', ['module' => ucfirst($module)]) }}
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
    <li><a href="{{ URL::route('dashboard.setting.index') }}"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.settings') }}</a></li>
    <li class="active"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.module settings', ['module' => ucfirst($module)]) }}</li>
</ol>
@stop

@section('styles')
<link href="{{{ Module::asset('core', 'css/vendor/iCheck/flat/blue.css') }}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
<?php use Illuminate\Support\Str; ?>
@include('flash::message')
{!! Form::open(['route' => ['dashboard.setting.store'], 'method' => 'post']) !!}
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">{{ trans('core::core.title.translatable fields') }}</h3>
            </div>
            <?php if ($translatableSettings): ?>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php $i = 0; ?>
                        <?php foreach(LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                            <?php $i++; ?>
                            <li class="{{ App::getLocale() == $locale ? 'active' : '' }}">
                                <a href="#tab_{{ $i }}" data-toggle="tab">{{ trans('core::core.tab.'. strtolower($language['name'])) }}</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <?php $i = 0; ?>
                        <?php foreach(LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                            <?php $i++; ?>
                            <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                <?php foreach($translatableSettings as $settingName => $moduleInfo): ?>
                                    <?php $fieldView = Str::contains($moduleInfo['view'], '::') ? $moduleInfo['view'] : "setting::admin.fields.translatable.{$moduleInfo['view']}" ?>
                                    @include($fieldView, [
                                        'lang' => $locale,
                                        'settings' => $settings,
                                        'module' => $module,
                                        'setting' => $settingName,
                                        'moduleInfo' => $moduleInfo,
                                    ])
                                <?php endforeach; ?>
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
                <?php foreach($plainSettings as $settingName => $moduleInfo): ?>
                    <?php $fieldView = Str::contains($moduleInfo['view'], '::') ? $moduleInfo['view'] : "setting::admin.fields.plain.{$moduleInfo['view']}" ?>
                    @include($fieldView, [
                        'lang' => $locale,
                        'settings' => $settings,
                        'module' => $module,
                        'setting' => $settingName,
                        'moduleInfo' => $moduleInfo,
                    ])
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
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
