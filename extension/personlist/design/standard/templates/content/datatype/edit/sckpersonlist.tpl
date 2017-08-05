{let HasPrimary=ezini('GeneralSettings', 'HasPrimaryPerson', 'personlist.ini')}

{literal}
<script language="JavaScript" type="text/javascript">
<!--

function doStuff( allbox )
{
  for(i=0; i<document.forms.length; i++)
  {
    for( j=0; j<document.forms[i].elements.length; j++)
    {
      var elem = document.forms[i].elements[j];
      {/literal}
      if( elem.type == "checkbox" && elem.name.indexOf( '_domail_{$attribute.id}' ) != -1  ){literal}
      {
        elem.checked = allbox.checked;
      }
    }
  }
}
//-->
</script>
{/literal}

<input type="hidden" name="ContentObjectAttribute_data_sckperson_usernode_{$attribute.id}" value="{$attribute.content.user_node}" />
<input type="hidden" name="ContentObjectAttribute_data_sckperson_userclasses_{$attribute.id}" value="{$attribute.content.user_classes|implode(';')}" />

<table class="list" cellspacing="0">
<tr>
	<th>&nbsp;</th>
	<th>Name</th>
  <th>First name</th>
	<th>E-Mail</th>
  <th>E-mail this person<br />
    <input type="checkbox" id="checkAll_{$attribute.id}" name="checkAll_{$attribute.id}" onclick="javascript:doStuff(this);" /></th>
  {switch match=$attribute.object.content_class.identifier}
  {case in=$HasPrimary}
  <th>Primary Person</th>
  {/case}
  {case}
  {/case}
  {/switch}
</tr>
{section name=Author loop=$attribute.content.person_list sequence=array(bglight,bgdark)}
<tr>
	<td width="3%" class="{$Author:sequence}">
	  <input type="checkbox" name="ContentObjectAttribute_data_sckperson_remove_{$attribute.id}[]" value="{$Author:index}" />
	</td>
	<td class="{$Author:sequence}">
	  <input type="hidden" name="ContentObjectAttribute_data_sckperson_id_{$attribute.id}[]" value="{$Author:index}" />
    <input type="hidden" name="ContentObjectAttribute_data_sckperson_userid_{$attribute.id}[]" value="{$Author:item.id}" />
	  <input type="hidden" readonly="readonly" name="ContentObjectAttribute_data_sckperson_name_{$attribute.id}[]" value="{$Author:item.name|wash}" />{$Author:item.name|wash}
	</td>
  <td class="{$Author:sequence}">
    <input type="hidden" name="ContentObjectAttribute_data_sckperson_firstname_{$attribute.id}[]" value="{$Author:item.firstname|wash}" />{$Author:item.firstname|wash}
  </td>
	<td class="{$Author:sequence}">
	  <input type="hidden" name="ContentObjectAttribute_data_sckperson_email_{$attribute.id}[]" value="{$Author:item.email|wash}" />{$Author:item.email|wash}
	</td>
  <td class="{$Author:sequence}">
    {section show=$Author:item.email|ne("")}
    <input type="checkbox" name="ContentObjectAttribute_data_sckperson_domail_{$attribute.id}[]" value="{$Author:index}" {section show=$Author:item.do_mail|eq(1)}checked="checked"{/section} />
    {/section} 
  </td>
  {switch match=$attribute.object.content_class.identifier}
  {case in=$HasPrimary}
  <td class="{$Author:sequence}">
  {section show=$Author:item.sckid|ne("")}
    <input type="radio" name="ContentObjectAttribute_data_sckperson_firstauthor_{$attribute.id}" value="{$Author:index}" {section show=$Author:item.firstauthor|eq(true())}checked="checked"{/section} />
  {section-else}
  &nbsp;
  {/section}
  </td>
  {/case}
  {case}
  {/case}
  {/switch}
</tr>
{/section}
</table>

<br />

<div class="element">
  <label>Internal {$attribute.contentclass_attribute.name}</label><div class="labelbreak"></div>
  <select name="ContentObjectAttribute_data_sckperson_newuserid_{$attribute.id}[]" multiple="multiple" size="10">
    {*<option selected="selected"></option>*}
    {$attribute.content.users}
  </select>
  
  <br /><br />
  <div class="buttonblock">
    <input class="button" type="submit" name="CustomActionButton[{$attribute.id}_new_author]" value="Add {$attribute.contentclass_attribute.name}" />
    <input class="button" type="submit" name="CustomActionButton[{$attribute.id}_remove_selected]" value="Remove Selected" />
  </div>
</div>

<div class="element">
  <label>External {$attribute.contentclass_attribute.name}</label><div class="labelbreak"></div>
  <div class="block">
    <!--<div>-->  
      <table cellspacing="0" cellpadding="0">
        <tr>
          <td><label class="small">Name</label></td>
		      <td><input type="text" name="ContentObjectAttribute_data_sckperson_newname_{$attribute.id}" value="" /></td>
        </tr>
      <!--</table>
    </div>
    
    <div>
      <table>-->
        <tr>
          <td><label class="small">Firstname</label></td>
		      <td><input type="text" name="ContentObjectAttribute_data_sckperson_newfirstname_{$attribute.id}" value="" /></td>
        </tr><!--
      </table>
    </div>
    
    <div>
      <table>-->
        <tr>
          <td><label class="small">Email</label></td>
		      <td><input type="text" name="ContentObjectAttribute_data_sckperson_newemail_{$attribute.id}" value="" /></td>
        </tr>
      </table>
    </div>   
  </div>
</div>

<div class="element">
  <input type="checkbox" name="ContentObjectAttribute_data_sckperson_onnew_{$attribute.id}" {section show=$attribute.content.new_objects|ne(false())}checked="checked"{/section} /><label>Email new object</label>
  <br />
  <input type="checkbox" name="ContentObjectAttribute_data_sckperson_onupdate_{$attribute.id}" {section show=$attribute.content.updated_objects|ne(false())}checked="checked"{/section} /><label>Email updated object</label>
</div>

{literal}
<script language="JavaScript" type="text/javascript">
<!--
var allChecked = true;
var count = 0;

for(i=0; i<document.forms.length; i++)
{
    for( j=0; j<document.forms[i].elements.length; j++)
    {
      var elem = document.forms[i].elements[j];
      {/literal}
      if( elem.type == "checkbox" && elem.name.indexOf( '_domail_{$attribute.id}' ) != -1  ){literal}
      {
        if( !elem.checked )
        {
          allChecked = false;
        }
        count++;          
      }
    }
}

{/literal}
var all = document.getElementById('checkAll_{$attribute.id}');
{literal}
if( all != null && count > 0 )
{
  all.checked = allChecked;
}
//-->
</script>
{/literal}


<div class="break"></div>

<br />
{/let}
