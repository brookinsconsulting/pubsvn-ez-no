{default attribute_base='ContentObjectAttribute'
         html_class='full'}
<textarea class="{eq($html_class,'half')|choose('box','halfbox')}" name="{$attribute_base}_data_text_{$attribute.id}" cols="70" rows="{$attribute.contentclass_attribute.data_int1}">{$attribute.content}</textarea>
{/default}