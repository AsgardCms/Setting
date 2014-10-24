<?php $settingName = $module . '_' . $setting; ?>
<div class='form-group'>
    {!! Form::label($settingName", $moduleInfo['description']) !!}
    <?php if (isset($settings[$settingName])): ?>
        {!! Form::textarea($settingName", Input::old($settingName", $settings[$settingName]->translate($lang)->value), ['class' => 'form-control', 'placeholder' => $moduleInfo['description']]) !!}
    <?php else: ?>
        {!! Form::textarea($settingName", Input::old($settingName"), ['class' => 'form-control', 'placeholder' => $moduleInfo['description']]) !!}
    <?php endif; ?>
</div>
