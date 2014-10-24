<?php $settingName = $module . '_' . $setting; ?>
<div class="checkbox">
    <label for="{{ $settingName }}">
        <input id="{{ $settingName }}"
                name="{{ $settingName }}"
                type="checkbox"
                class="flat-blue"
                {{ isset($settings[$settingName]) && (bool)$settings[$settingName]->value == true ? 'checked' : '' }}
                value="1" />
        {{ $moduleInfo['description'] }}
    </label>
</div>
