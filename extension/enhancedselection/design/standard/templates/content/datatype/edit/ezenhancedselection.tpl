{default attribute_base="ContentObjectAttribute"}
{let selected_id_array=$attribute.content}

<select name="{$attribute_base}_ezenhancedselect_selected_array_{$attribute.id}[]" {section show=$attribute.class_content.is_multiselect}multiple="multiple"{/section}>
    {section name=Option loop=$attribute.class_content.options}
    <option value="{$Option:item.identifier}" {section show=$selected_id_array|contains($Option:item.identifier)}selected="selected"{/section}>{$Option:item.name|wash(xhtml)}</option>
    {/section}
</select>
{section show=$attribute.contentclass_attribute.is_required}
<span class="required_field">*</span>
{/section}

{/let}
{/default}