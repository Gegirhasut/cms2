<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" role="form" id="form" action="{$form.action}">
            {foreach from=$form.model->fields item=field key=key}
                {if !isset($field.nolist)}
                    <div class="form-group" id="key_{$key}">
                        <label for="{$key}" class="col-sm-{$form.label_width} control-label">{$field.title}</label>
                        <div class="col-sm-{$form.field_width}">
                            {if $field.type eq 'select'}
                                <input type="hidden" name="{$key}" id="{$key}" style="width:100%" value="{$form.value[$key]}" placeholder="{$field.placeholder}">
                            {elseif $field.type eq 'password'}
                                <input type="{$field.type}" class="form-control" id="{$key}" name="{$key}" placeholder="{$field.placeholder}">
                            {else}
                                <input type="{$field.type}" class="form-control" id="{$key}" name="{$key}" value="{$form.value[$key]}" placeholder="{$field.placeholder}">
                            {/if}
                            {if isset ($field.help_block)}
                                <span class="help-block">{$field.help_block}</span>
                            {/if}
                        </div>
                    </div>
                {/if}
            {/foreach}
        </form>

        <input type="hidden" id="help_width" value="{$form.help_width}" />

        <div class="form-group">
            <div class="col-sm-offset-{$form.label_width}">
                <button type="submit" class="btn btn-default" id="form_btn">{$form.action_name}</button>
            </div>
        </div>
    </div>
</div>