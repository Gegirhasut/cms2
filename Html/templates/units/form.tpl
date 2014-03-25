<script src="/Libs/Bootstrap-3.1.0/js/bootstrap-maxlength.min.js"></script>

<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" role="form" id="form" action="{$form.action}">
            {foreach from=$form.model->fields item=field key=key}
                {if !isset($field.nolist)}
                    <div class="form-group" id="key_{$key}">
                        <label for="{$key}" class="col-sm-{$form.label_width} control-label">{$field.title}</label>
                        <div class="col-sm-{if isset($field.width)}{$field.width}{else}{$form.field_width}{/if}">
                            {assign var="file_name" value=$field.type}
                            {assign var="file_name_full" value=Html/templates/units/fields/$file_name.tpl}
                            {assign var="file_name_tpl" value=units/fields/$file_name.tpl}

                            {if file_exists($file_name_full)}
                                {include file=$file_name_tpl}
                            {else}
                                <input type="{$field.type}" class="form-control" id="{$key}" name="{$key}" value="{$form.value[$key]}" placeholder="{$field.placeholder}" {if isset($field.maxlength)}maxlength="{$field.maxlength}"{/if}>
                                <script>
                                    $('#{$key}').maxlength({ldelim}
                                        alwaysShow: true
                                    {rdelim});
                                </script>
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
        <input type="hidden" id="help_offset" value="{$form.help_offset}" />

        <div class="form-group">
            <div class="col-sm-offset-{$form.label_width}">
                <button type="submit" class="btn btn-info" id="form_btn">{$form.action_name}</button>
            </div>
        </div>
    </div>
</div>