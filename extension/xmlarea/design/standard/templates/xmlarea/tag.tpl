  <script type="text/javascript" src="/extension/xmlarea/design/standard/javascript/popup.js"></script>
  <script type="text/javascript">
  
  var numrows = 1;
  var isCustomTag = '{$isCustomTag}';
  var tagName = '{$tagName}';
  
  {literal}

    
      window.resizeTo(400, 300);
    function Init()
    {
        return;
      //__dlg_init();
      //window.resizeTo(300, 400);
      //var param = window.dialogArguments;
    };
    
    function getElementByID( tag, id )
    {
        var el, i, objs = document.getElementsByTagName( tag );
	    for (i = objs.length; --i >= 0 && (el = objs[i]);)
		    if (el.id == id)
        return el;
    }
    
    function onOK()
    {
        var names = document.getElementsByName("customAttributeName");
        var values = document.getElementsByName("customAttributeValue");
        var custom = '';
        var param = new Object();
        param['tag'] = tagName;
        param['isCustomTag'] = ( isCustomTag == '' ) ? false : true;
        param['atts'] = [];
        
        if ( names != null )
        {
            if ( names.length != null )
            {
                for (var i=0;i<names.length;i++)
                {                
                    if ( names[i].value != '' )
                    {
                        
                        if ( isCustomTag == '' )
                        {
                            param['atts'][i] = [names[i].value, values[i].value];
                        }
                        else
                        {
                            if ( names[i].value.toLowerCase() == 'class' )
                                param['atts'][i] = ['class', values[i].value];
                            custom += names[i].value + '|' + values[i].value + '|';
                        }
                    }
                }
            }
            else
            {
                if ( names.value != '' )
                {
                    custom += names.value + '|' + values.value + '|';
                }
            }
        }
        
        if ( custom != '' )
            param['custom'] = custom;
        
        __dlg_close(param);
        return false;
    }
    
    function onCancel()
    {
        __dlg_close(null);
        return false;
    };
    
    function addAttribute()
    {
        index = 0;
        if (typeof document.frm.AttributeArray != 'undefined' )
        {
            arr = document.frm.AttributeArray;
            index = arr.length;
            if ( typeof index == 'undefined' )
                index = 1;
        }
            
            
        table = document.getElementById("attributes").getElementsByTagName("tbody")[0];
        //lasttr = document.getElementById( 'lasttr' );
        tr = document.createElement( 'tr' );
        //lastclass = table.lastChild.className;
        //newclass = ( lastclass == 'bgdark' ) ? 'bglight' : 'bgdark';
        //tr.className = newclass;
        tr.id = 'attributetr-' + index;
        td1 = document.createElement( 'td' );
        input = document.createElement("input");
        input.setAttribute( 'type', 'checkbox' );
        input.setAttribute( 'name', 'AttributeArray' );
        input.setAttribute( 'id', 'AttributeArray' );
        td1.appendChild( input );
        //td1.innerHTML = '<input type="checkbox" name="" value="' +  + '" />';
        td2 = document.createElement( 'td' );
        input = document.createElement("input");
        input.setAttribute( 'type', 'text' );
        input.setAttribute( 'size', '15' );
        input.setAttribute( 'name', 'customAttributeName' );
        input.setAttribute( 'id', 'customAttributeName' );
        td2.appendChild( input );
        //td2.innerHTML = '<input type="text" class="halfbox" value="" name="' + curCustomID + '" />';
        td3 = document.createElement( 'td' );
        input = document.createElement("input");
        input.setAttribute( 'type', 'text' );
        input.setAttribute( 'size', '15' );
        input.setAttribute( 'name', 'customAttributeValue' );
        input.setAttribute( 'id', 'customAttributeValue' );
        td3.appendChild( input );
        //td3.innerHTML = '<input type="text" class="halfbox" value="" name="customAttributeContent' + curCustomID + '" />';
        tr.appendChild( td1 );
        tr.appendChild( td2 );
        tr.appendChild( td3 );
        table.insertBefore( tr, null );
    }
    
    function removeAttributes()
    {
        
        var table = document.getElementById("attributes");
        var CustomAttributeName = document.getElementsByName("customAttributeName");
        var Selected_attribute = document.getElementsByName("AttributeArray");
        if (  CustomAttributeName.length != null )
        {
            if ( Selected_attribute.length != null )
            {   
                var deleteArray = new Array();
                var deleteArrayIndex = 0;
                for (var i=0;i<Selected_attribute.length;i++)
                {                
                    if ( Selected_attribute[i].checked == true )
                    {                    
                        deleteArray[deleteArrayIndex] = i;
                        deleteArrayIndex++;
                    }
                }
                for (var j=0;j<deleteArray.length;j++)
                {                
                    rowIndex = numrows + deleteArray[j];
                    table.deleteRow(rowIndex);
                    baseIndex--;
                }        
            }
            else
            {            
                if ( Selected_attribute.checked == true )
                    table.deleteRow(numrows);
            }
        }
    }
    
    
</script>
{/literal}

<form method="post" name="frm">

<div id="maincontent" style="margin-left: 1em; margin-right: 1em;">
<div id="maincontent-design">

<div class="content-edit">

<div class="context-block" id="content-relation-items">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">{$title}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

        <div class="related-detail-list">
            {let class_array=array( bglight, bgdark ) }
            <table class="list" cellspacing="0" id="attributes">
            <tbody id="attributetable">
            <tr>
                {section show=$isCustomTag}<th>&nbsp;</th>{/section}
                <th>{'Attribute name'|i18n( 'design/admin/content/edit' )}</th>
                <th>{'Value'|i18n( 'design/admin/content/edit' )}</th>
            </tr>
                {section loop=$attributes sequence=array(bglight, bgdark)}
                <tr class="{$:sequence}" id="attributetr-{$:index}">
                    {section show=$isCustomTag}<td class="checkbox"><input type="checkbox" id="AttributeArray" name="AttributeArray" value="{$:index}" /></td>{/section}
                    <td>
                        {section show=$isCustomTag}
                        <input type="text" size="15" value="{$:item.0}" name="customAttributeName" />
                        {section-else}
                        {$:item.2}
                        <input type="hidden" value="{$:item.0}" name="customAttributeName" />
                        {/section}
                    </td>
                    <td>
                        {section show=or($isCustomTag, ne($:item.0, 'class'))}
                        <input type="text" size="15" value="{$:item.1}" name="customAttributeValue" />
                        {section-else}
                            <select name="customAttributeValue">
                              <option value="">[none]</option>
                              {let class=$:item.1}
                              {section loop=$availableClasses}
                                <option value="{$:item}" {section show=eq($class, $:item)}selected="selected" {/section}>{$:item}</option>
                              {/section}
                              {/let}
                            </select>
                        {/section}
                    </td>
                </tr>
                {/section}
               </tbody>
            </table>
        </div>
{section show=$isCustomTag}
<div class="block">

<input class="button" type="button" onclick="removeAttributes()" value="Remove selected" />
<input class="button"  type="button" onclick="addAttribute();" value="Add attribute" />

</div>
{/section}


{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block" style="text-align: center">

<input class="button"  type="button" name="ok" onclick="return onOK();" value="OK" />
<input class="button"  type="button" name="cancel" onclick="return onCancel();" value="Cancel" />

</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>

</div>

</div>

</div>

</div></div></form>