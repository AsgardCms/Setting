<?php $settingName = $module . '::' . $setting; ?>
<div class='form-group'>
    {!! Form::label($settingName, $moduleInfo['description']) !!}
    <?php if (isset($settings[$settingName])): ?>
        {!! Form::text($settingName, Input::old($settingName, $settings[$settingName]->plainValue), ['class' => 'form-control', 'placeholder' => $moduleInfo['description']]) !!}
    <?php else: ?>
        {!! Form::text($settingName, Input::old($settingName), ['class' => 'form-control', 'placeholder' => $moduleInfo['description']]) !!}
    <?php endif; ?>
</div>
