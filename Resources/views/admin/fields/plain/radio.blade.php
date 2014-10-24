<?php $settingName = $module . '_' . $setting; ?>
<div class="checkbox">
    <?php foreach($moduleInfo['options'] as $value => $optionName): ?>
        <label for="{{ $optionName }}">
                <input id="{{ $optionName }}"
                        name="{{ $settingName }}"
                        type="radio"
                        class="flat-blue"
                        {{ isset($settings[$settingName]) && (bool)$settings[$settingName]->value == $value ? 'checked' : '' }}
                        value="{{ $value }}" />
                {{ $optionName }}
        </label>
    <?php endforeach; ?>
</div>
