<div class='form-group'>
    {!! Form::label($settingName . "[$lang]", trans($moduleInfo['description'])) !!}
    <?php if (isset($dbSettings[$settingName])): ?>
        <?php $object = $dbSettings[$settingName]->translate($lang); ?>
        <?php $value = isset($object) ? $object->value : '' ?>
        {!! Form::text($settingName . "[$lang]", Input::old($settingName . "[$lang]", $value), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php else: ?>
        {!! Form::text($settingName . "[$lang]", Input::old($settingName . "[$lang]"), ['class' => 'form-control', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php endif; ?>
</div>
