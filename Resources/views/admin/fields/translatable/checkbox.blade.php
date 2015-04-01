<div class="checkbox">
    <?php $oldValue = $dbSettings[$settingName]->hasTranslation($lang) ? $dbSettings[$settingName]->translate($lang)->value : ''; ?>
    <label for="{{ $settingName . "[$lang]" }}">
        <input id="{{ $settingName . "[$lang]" }}"
                name="{{ $settingName . "[$lang]" }}"
                type="checkbox"
                class="flat-blue"
                {{ isset($dbSettings[$settingName]) && (bool)$oldValue == true ? 'checked' : '' }}
                value="1" />
        {{ trans($moduleInfo['description']) }}
    </label>
</div>
