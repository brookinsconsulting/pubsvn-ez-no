{let class_content=$class_attribute.content}
<div class="block">
    <div class="element">
        <label>Delimiter:</label>
        <input type="text" name="ContentClass_ezenhancedselection_delimiter_{$class_attribute.id}" value="{$class_attribute.content.delimiter|wash}" size="5"/>
    </div>
    
    <div class="element">
        <input type="checkbox" name="ContentClass_ezenhancedselection_ismultiple_value_{$class_attribute.id}" {section show=$class_content.is_multiselect}checked{/section} /> <b>Multiple choice</b>
    </div>
</div>

<div class="block">
    <table border="0" width="50%">
        <tr>
            <th>Value</th>
            <th>Identifier</th>
            <th width="3%">Priority</th>
            <th colspan="3">&nbsp;</th>
        </tr>
    
        {section var=option loop=$class_content.options}
        <tr>
            <td><input type="text" name="ContentClass_ezenhancedselection_option_name_array_{$class_attribute.id}[{$option.item.id}]" value="{$option.item.name}" /></td> 
            <td><input type="text" name="ContentClass_ezenhancedselection_option_identifier_array_{$class_attribute.id}[{$option.item.id}]" value="{$option.item.identifier}" /></td>
            <td><input type="text" name="ContentClass_ezenhancedselection_option_priority_array_{$class_attribute.id}[{$option.item.id}]" value="{cond(is_set($option.item.priority),$option.item.priority,$option.number)}" size="2" /></td>
            <td><input type="image" name="Move_option_up_{$class_attribute.id}[{$option.item.id}]" src={"button-move_up.gif"|ezimage} value="Move up"/></td>
            <td><input type="image" name="Move_option_down_{$class_attribute.id}[{$option.item.id}]" src={"button-move_down.gif"|ezimage} value="Move down" /></td>
            <td><input type="checkbox" name="ContentClass_ezenhancedselection_option_remove_array_{$class_attribute.id}[{$option.item.id}]" /></td>
        </tr>
        {/section}
    </table>
</div>

<input type="submit" name="ContentClass_ezenhancedselection_newoption_button_{$class_attribute.id}" value="{"New option"|i18n("design/standard/class/datatype")}"/>
<input type="submit" name="ContentClass_ezenhancedselection_removeoption_button_{$class_attribute.id}" value="{"Remove selected"|i18n("design/standard/class/datatype")}"/>
<input type="submit" name="Sort_options_{$class_attribute.id}" value="Sort options" />
<select name="Sort_options_order_{$class_attribute.id}">
    <option value="alpha_asc">A-Z</option>
    <option value="alpha_desc">Z-A</option>
    <option value="prior_asc">Priority</option>
</select>
{/let}



