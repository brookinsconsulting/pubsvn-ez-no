{let content=$class_attribute.content
     class_list=fetch('class', 'list')}
   
<table class="list" cellspacing="0">
  <tr>
    <td>
      <label>User classes:</label><div class="labelbreak"></div>
      <select name="ContentClass_data_sckpersonlist_classes_{$class_attribute.id}[]" multiple="multiple" size="8">
        {section var=class loop=$class_list}
        <option value="{$class.item.identifier}" {section show=$content.classes|contains($class.item.identifier)}selected="selected"{/section}>{$class.item.name|wash}</option>
        {/section}
      </select>
    </td>
  
    <td>
      <table cellpadding="0" cellspacing="5">
        <tr>
          <td>
            <input type="checkbox" name="ContentClass_data_sckpersonlist_onnew_{$class_attribute.id}" {section show=$content.on_new|eq(1)}checked="checked"{/section} /> Email new objects
          </td>
        </tr>
        <tr>
          <td>
            <input type="checkbox" name="ContentClass_data_sckpersonlist_onupdate_{$class_attribute.id}" {section show=$content.on_update|eq(1)}checked="checked"{/section} /> Email updated objects
          </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="ContentClass_data_sckpersonlist_useowner_{$class_attribute.id}" {section show=$content.use_owner|eq(1)}checked="checked"{/section} /> Use owner as default value
            </td>
        </tr>
        <tr>
          <td>
            Users' Node:
            {section show=$content.node_id|ne(0)}
              {let node=fetch('content','node',hash(node_id,$content.node_id))}
              <b>{$node.name|wash}</b>
              {/let}
            {/section}
            <br /><br />
            <input class="button" type="submit" name="CustomActionButton[{$class_attribute.id}_browse_for_placement]" value="Select users' node" />
            <input type="hidden" name="ContentClass_data_sckpersonlist_nodeid_{$class_attribute.id}" value="{$content.node_id}" />
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
{/let}