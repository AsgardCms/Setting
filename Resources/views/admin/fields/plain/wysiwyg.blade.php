<div class='form-group'>
    {!! Form::label($settingName, trans($moduleInfo['description'])) !!}
    <?php if (isset($dbSettings[$settingName])): ?>
        {!! Form::textarea($settingName, Input::old($settingName, $dbSettings[$settingName]->plainValue), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php else: ?>
        {!! Form::textarea($settingName, Input::old($settingName), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php endif; ?>
</div>
