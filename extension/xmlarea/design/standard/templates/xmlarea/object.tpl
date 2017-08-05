{let classes=ezini('object','AvailableClasses','content.ini')}
  <script type="text/javascript" src={"/extension/xmlarea/design/standard/javascript/popup.js"|ezroot}></script>
  <script type="text/javascript" src={"/extension/xmlarea/design/standard/javascript/pagestyle.js"|ezroot}></script>
  <script type="text/javascript">
  
  var numrows = {cond(eq( count( $classes ), 0), 6, 7 )};
  
  {literal}
  
  var latin1 = '<span class="latin">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut consectetuer malesuada erat. Aliquam enim odio, dapibus eu, ultricies eu, varius vitae, leo.</span>';
  var latin2 = '<span class="latin">Praesent auctor. Nunc id purus sit amet libero vehicula tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec faucibus nunc id leo. Maecenas scelerisque. Aenean hendrerit, elit sit amet tristique semper, turpis nibh elementum risus, at facilisis dolor eros at orci. Proin ut risus eget erat vulputate ornare. Aliquam sed diam. Nunc fringilla quam sit amet leo. Integer convallis. Maecenas adipiscing dui id nunc. Pellentesque vel massa. Morbi aliquam.</span>';
  var cssTimeout = null;    
  
    window.onload=Init();
    
    function Init() {
      window.resizeTo(560, 635);
      //__dlg_init();
      var param = window.dialogArguments;
      
      cssTimeout = setTimeout( function()
            {
                pre = getElementByID('iframe', 'ipreview');
                if ( pre != null )
                {
                    prev = getElementByID('div', 'hidden');
                    html = "<html>\n " +
			                        "<head>\n" +
                                    "<style> " +
				                    pageStyle + "</style>\n" + latin1 + prev.innerHTML + latin2 +
			                        "</head>\n" +
			                        "<body>\n" + 
			                        "</body>\n" +
			                        "</html>";
			        doc = pre.contentWindow.document;
			        doc.open();
        			doc.write(html);
        			doc.close();
                    clearTimeout( cssTimeout );
                }
            }
            , 50 );
      
      
    
    };
    
    
        
    
    function getElementByID( tag, id )
    {
        var el, i, objs = document.getElementsByTagName( tag );
	    for (i = objs.length; --i >= 0 && (el = objs[i]);)
		    if (el.id == id)
        return el;
    }
    
    function preview( isok )
    {
        if ( document.frm.DeleteRelationIDArray != undefined )
        {
            var radio = document.frm.DeleteRelationIDArray;
            
            if ( radio.length == null )
            {
                var id = radio.value;
            }
            else
            {
                for (i=0;i<radio.length;i++)
                {
                    if (radio[i].checked)
                    {
                        var id = radio[i].value;
                    }
                }
            }
        }
        else
        {
            return;
        }
                
        if ( id == '' || id == undefined )
        {
            if ( isok != null )
            {
                okCallback( '' );
            }
            
            return false;
        }

        var custom = 'id|' + id;
        custom += '|align|' + document.frm.align.value;
        custom += '|size|' + document.frm.size.value;
        custom += '|view|' + document.frm.view.value;
        if ( document.frm.cssclass != null )
            custom += '|class|' + document.frm.cssclass.value;
        custom += '|ezurl_id|' + '';
        custom += '|ezurl_href|' + document.frm.url.value;
        custom += '|target|' + document.frm.urltarget.value;
        
        var names = document.getElementsByName("customAttributeName");
        values = document.getElementsByName("customAttributeValue");
        
        if ( names != null )
        {
            if ( names.length != null )
            {
                for (var i=0;i<names.length;i++)
                {                
                    if ( names[i].value != '' )
                    {                    
                        custom += '|' + names[i].value + '|' + values[i].value;
                    }
                }
            }
            else
            {
                if ( names.value != '' )
                {                    
                    custom += '|' + names.value + '|' + values.value;
                }
            }
        }
        
        var xmlhttp=false;
        /*@cc_on @*/
        /*@if (@_jscript_version >= 5)
        // JScript gives us Conditional compilation, we can cope with old IE versions.
        // and security blocked creation of the objects.
         try {
          xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
          try {
           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (E) {
           xmlhttp = false;
          }
         }
        @end @*/
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
            xmlhttp = new XMLHttpRequest();
        }
     
        var str = 'content=' + escape( custom );
        
        xmlhttp.open("POST", {/literal}{"/xmlarea/xmlhttp/object"|ezurl()}{literal}, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        if ( isok != null )
        {
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4)
                    okCallback( xmlhttp.responseText );
            }
        }
        else
        {
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4)
                    previewCallback( xmlhttp.responseText );
            }
        }
        xmlhttp.send(str);
    }
        
    function okCallback( returnstring )
    {
        var param = new Object();
        var arr = returnstring.split('{)!(}');
        
        if ( arr[1] != undefined )
        {
            previewCallback( returnstring );
            param['html'] = arr[1];
        }
        
        //alert(arr[1]);
        opener.Dialog._return(param);
        setTimeout('window.close()', 100);
    };
        
        
    
    function previewCallback( returnstring )
    {
        var param = new Object();
        var arr = returnstring.split('{)!(}');
        
        pre = getElementByID('iframe', 'ipreview');
        bod = pre.contentWindow.document.body;
        bod.innerHTML = latin1 + arr[0] + latin2;
    }
    
    function selectImage(id)
    {
        document.frm.objectid.value = id;
        
        preview();
        
    }
    
    function onOK()
    {
        preview( true );
    }
    
    function onPreview()
    {
        preview(null);
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

<form action={concat("xmlarea/relation/",$object_id,"/",$object_ver,"/",$object_lang,"/",$params)|ezurl} method="post" name="frm">
{*<form action={concat("/index.php/slog_admin/xmlarea/relation/",$object_id,"/",$object_ver,"/",$object_lang,"/",$params)} method="post" name="frm">*}

<div id="maincontent" style="margin-left: 1em; margin-right: 1em;">
<div id="maincontent-design">

<div class="content-edit">

<div class="context-block" id="content-relation-items">

{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h1 class="context-title">Select from related objects</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>

{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

    <h3>{'Properties'|i18n( 'design/admin/content/edit' )}</h3>
        <div class="related-detail-list">
            {let class_array=array( bglight, bgdark ) }
            <table class="list" cellspacing="0" id="attributes">
            <tbody id="attributetable">
            <tr>
                <th>&nbsp;</th>
                <th width="200px">{'Attribute name'|i18n( 'design/admin/content/edit' )}</th>
                <th>{'Value'|i18n( 'design/admin/content/edit' )}</th>
            </tr>
                <tr class="bglight">
                    <td class="checkbox"></td>
                    <td>Size</td>
                    <td>
                        <select name="size"> 
                            <option value="">[none]</option>
                            <option value="original" >original</option>
                            {let sizes=ezini('AliasSettings','AliasList','image.ini')}
                            {section loop=$sizes}
                            <option value="{$:item}" {section show=eq($object_params.size, $:item)}selected="selected" {/section}>{$:item}</option>
                            {/section}
                            {/let}
                        </select>
                    </td>
                </tr>
                <tr class="bgdark">
                    <td class="checkbox"></td>
                    <td>Alignment</td>
                    <td>
                        <select size="1" name="align" id="f_align"
                          title="Positioning of this object">
                            <option value="">[none]</option>
                          <option {section show=eq($object_params.align, 'left')}selected="selected" {/section}value="left"                         >left</option>
                          <option {section show=eq($object_params.align, 'center')}selected="selected" {/section}value="center"                       >centre</option>
                          <option {section show=eq($object_params.align, 'right')}selected="selected" {/section}value="right"                        >right</option>
                        </select>
                    </td>
                </tr>
                
                {section show=ne( count( $classes ), 0 )}
                {set class_array=array( bgdark, bglight ) }
                <tr class="bglight">
                    <td class="checkbox"></td>
                    <td>Class</td>
                    <td>
                        
                        <select name="cssclass">
                            <option value="">[none]</option>
                            {section loop=$classes}
                            <option value="{$:item}" {section show=eq($object_params.class, $:item)}selected="selected" {/section}>{$:item}</option>
                            {/section}
                        </select>
                        </div>
                        {section-else}
                        <input type="hidden" value="{$object_params.class}" name="cssclass" />
                    </td>
                </tr>
                {/section}
                <tr class="{$class_array.0}">
                    <td class="checkbox"></td>
                    <td>View</td>
                    <td>
                        <select name="view">
                            <option value="">[none]</option>
                            <option value="embed" {section show=eq($object_params.view, 'embed')}selected="selected" {/section}>Embed</option>
                            <option value="text_linked" {section show=eq($object_params.view, 'text_linked')}selected="selected" {/section}>Text linked</option>
                        </select>
                    </td>
                </tr>
                <tr class="{$class_array.1}">
                    <td class="checkbox"></td>
                    <td>Link URL</td>
                    <td>
                        <input type="text" class="halfbox" value="{$object_params.ezurl_href}" name="url" />
                    </td>
                </tr>
                <tr class="{$class_array.0}" id="firsttr">
                    <td class="checkbox"></td>
                    <td>Link Target</td>
                    <td>        
                        <select size="1" name="urltarget">
                          <option value="">[none]</option>
                          <option value="_self" {section show=eq($object_params.ezurl_target, '_self')}selected="selected" {/section}>Same window</option>
                          <option value="_blank" {section show=eq($object_params.ezurl_target, '_blank')}selected="selected" {/section}>New window</option>
                        </select>
                    </td>
                </tr>
                {section loop=$object_params.custom sequence=array($class_array.1, $class_array.0)}
                <tr class="{$:sequence}" id="attributetr-{$:index}">
                    <td class="checkbox"><input type="checkbox" id="AttributeArray" name="AttributeArray" value="{$:index}" /></td>
                    <td>
                        <input type="text" size="15" value="{$:item.0}" name="customAttributeName" />
                    </td>
                    <td>
                        <input type="text" size="15" value="{$:item.1}" name="customAttributeValue" />
                    </td>
                </tr>
                {/section}
               </tbody>
            </table>
        </div>
<div class="block">

<input class="button" type="button" onclick="removeAttributes()" value="Remove selected" />
<input class="button"  type="button" onclick="addAttribute();" value="Add attribute" />

</div>

<h3>{'Preview'|i18n( 'design/admin/content/edit' )}</h3>
        <div class="related-detail-list" style="text-align: center">

    <iframe id="ipreview" style="left: auto; height: 200px; width: 430px; background-color: #fff; overflow: auto;"></iframe>
    
        </div>



{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block" style="text-align: center">

<input class="button" type="button" name="preview" onclick="return onPreview();" value="Preview" />
<input class="button"  type="button" name="ok" onclick="return onOK();" value="OK" />
<input class="button"  type="button" name="cancel" onclick="return onCancel();" value="Cancel" />

</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>

<p></p>

<div class="break"></div>



{* DESIGN: Header START *}<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">

<h2 class="context-title">{'Related objects [%related_objects]'|i18n( 'design/admin/content/edit',, hash( '%related_objects', $related_contentobjects|count ) )}</h2>

{* DESIGN: Subline *}<div class="header-subline"></div>

{* DESIGN: Header END *}</div></div></div></div></div></div>


{* DESIGN: Content START *}<div class="box-ml"><div class="box-mr"><div class="box-content">

{section show=$related_contentobjects|count|gt( 0 )}

    {* Related images *}
    {section show=$grouped_related_contentobjects.images|count|gt( 0 )}
    <h3>{'Related images [%related_images]'|i18n( 'design/admin/content/edit',, hash( '%related_images', $grouped_related_contentobjects.images|count ) )}</h3>
    <table class="list-thumbnails" cellspacing="0">
    <tr>

        {section var=RelatedImageObjects loop=$grouped_related_contentobjects.images}
        <td>
        <div class="image-thumbnail-item">
            {attribute_view_gui attribute=$RelatedImageObjects.item.data_map.image image_class=small}
            <p>
                <input {section show=eq($RelatedImageObjects.item.id, $insert_id)}checked="checked" {/section}type="radio" id="related-object-id-{$RelatedImageObjects.item.id}" name="DeleteRelationIDArray" value="{$RelatedImageObjects.item.id}" />
                {$RelatedImageObjects.item.name|wash}
           </p>
        </div>
        </td>
        {delimiter modulo=4}
        </tr><tr>
        {/delimiter}
        {/section}

    </tr>
    </table>

    {/section}



    {* Related files *}
    {section show=$grouped_related_contentobjects.files|count|gt( 0 )}
    <h3>{'Related files [%related_files]'|i18n( 'design/admin/content/edit',, hash( '%related_files', $grouped_related_contentobjects.files|count ) )}</h3>
        <div class="file-detail-list">

            <table class="list" cellspacing="0">
            <tr>
                <th>&nbsp;</th>
                <th class="name">{'Name'|i18n( 'design/admin/content/edit' )}</th>
                <th class="class">{'File type'|i18n( 'design/admin/content/edit' )}</th>
                <th class="filesize">{'Size'|i18n( 'design/admin/content/edit' )}</th>
            </tr>

            {section var=RelatedFileObjects loop=$grouped_related_contentobjects.files sequence=array( bglight, bgdark )}
                <tr class="{$RelatedFileObjects.sequence|wash}">
                    <td class="checkbox"><input {section show=eq($RelatedFileObjects.item.id, $insert_id)}checked="checked" {/section}type="radio" id="related-object-id-{$RelatedFileObjects.item.id}" name="DeleteRelationIDArray" value="{$RelatedFileObjects.item.id}" /></td>
                    <td class="name">{$RelatedFileObjects.item.class_name|class_icon( small, $RelatedFileObjects.class_name )}&nbsp;{$RelatedFileObjects.item.name|wash}</td>
                    <td class="filetype">{$RelatedFileObjects.item.data_map.file.content.mime_type|wash}</td>
                    <td class="filesize">{$RelatedFileObjects.item.data_map.file.content.filesize|si( byte )}</td>
                </tr>
            {/section}

            </table>
        </div>
    {/section}


    {* Related objects *}
    {section show=$grouped_related_contentobjects.objects|count|gt( 0 )}
    <h3>{'Related content [%related_objects]'|i18n( 'design/admin/content/edit',, hash( '%related_objects', $grouped_related_contentobjects.objects|count ) )}</h3>
        <div class="related-detail-list">

            <table class="list" cellspacing="0">
            <tr>
                <th>&nbsp;</th>
                <th class="name">{'Name'|i18n( 'design/admin/content/edit' )}</th>
                <th class="class">{'Type'|i18n( 'design/admin/content/edit' )}</th>
            </tr>

            {section var=RelatedObjects loop=$grouped_related_contentobjects.objects sequence=array( bglight, bgdark )}

                <tr class="{$RelatedObjects.sequence|wash}">
                    <td class="checkbox"><input {section show=eq($RelatedObjects.item.id, $insert_id)}checked="checked" {/section}type="radio" id="related-object-id-{$RelatedObjects.item.id}" name="DeleteRelationIDArray" value="{$RelatedObjects.item.id}" /></td>
                    <td class="name">{$RelatedObjects.item.class_name|class_icon( small, $RelatedObjects.class_name )}&nbsp;{$RelatedObjects.item.name|wash}</td>
                    <td class="class">{$RelatedObjects.item.class_name|wash}</td>
                </tr>

            {/section}

            </table>
        </div>
    {/section}

{section-else}
<div class="block">
<p>{'There are no objects related to the one that is currently being edited.'|i18n( 'design/admin/content/edit' )}</p>
</div>
{/section}

{* DESIGN: Content END *}</div></div></div>

<div class="controlbar">
{* DESIGN: Control bar START *}<div class="box-bc"><div class="box-ml"><div class="box-mr"><div class="box-tc"><div class="box-bl"><div class="box-br">
<div class="block" style="text-align: center">

    {*<-- input class="button" type="Submit" name="BrowseObjectButton" value="{'Add existing'|i18n( 'design/admin/content/edit' )}" title="{'Add an existing item as a related object.'|i18n( 'design/admin/content/edit' )}" -->*}
    <input class="button" type="submit" name="BrowseObjectButton" value="{'Add existing'|i18n( 'design/admin/content/edit' )}" title="{'Add an existing item as a related object.'|i18n( 'design/admin/content/edit' )}" />
    <input class="button" type="submit" name="UploadFileRelationButton" value="{'Upload new'|i18n( 'design/admin/content/edit' )}" title="{'Upload a file and add it as a related object.'|i18n( 'design/admin/content/edit' )}" />
</div>
{* DESIGN: Control bar END *}</div></div></div></div></div></div>
</div>

</div>

</div>

</div></div>



<input type="hidden" value="{$insert_id}" name="objectid" />


</form>

<div id="hidden" style="height: 1px; width: 1px; visibility: hidden">{$preview}</div>
{/let}