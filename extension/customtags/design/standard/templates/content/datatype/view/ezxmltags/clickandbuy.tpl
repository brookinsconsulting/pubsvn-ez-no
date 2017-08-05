<div class="tag-clickandbuy">
{default
    on0=ezini($type,'on0','customtag.ini')
    os0=ezini($type,'os0','customtag.ini')
    os0_type=ezini($type,'os0_type','customtag.ini')
    on1=ezini($type,'on1','customtag.ini')
    os1=ezini($type,'os1','customtag.ini')
    os1_type=ezini($type,'os1_type','customtag.ini')
    image=ezini($type,'image','customtag.ini')
    image_alt=ezini($type,'image_alt','customtag.ini')
    a3=ezini($type,'a3','customtag.ini')
    p3=ezini($type,'p3','customtag.ini')
    t3=ezini($type,'t3','customtag.ini')
    src=ezini($type,'src','customtag.ini')
    sra=ezini($type,'sra','customtag.ini')
    cmd=ezini($type,'cmd','customtag.ini')
    business=ezini($type,'business','customtag.ini')
    item_name=ezini($type,'item_name','customtag.ini')
    item_number=ezini($type,'item_number','customtag.ini')
    no_note=ezini($type,'no_note','customtag.ini')
    currency_code=ezini($type,'currency_code','customtag.ini')
}
</form>
<fieldset>
    <legend>{$content}</legend>
    <form name="{$content}" action="{ezini('PayPalSettings','URL','customtag.ini')}" method="post">
    <div style="float:left;margin:5px;">
                        {switch match=$os0_type}
                        {case match='select'}
                        <select name="os0">
                            <label>{$on0}</label><br />
                            <input type="hidden" name="on0" value="{$on0}">
                            {section loop=$os0|explode(ezini('PayPalSettings','Delimiter','customtag.ini'))}
                                <option value="{$:item}">{$:item}</option>
                            {/section}
                        </select>
                        {/case}
                        {case match='input'}
                            <label>{$on0}</label><br />
                            <input type="hidden" name="on0" value="{$on0}">
                            <input name="os0" type="text" value="{$os0}" size="10" maxlength="60">
                        {/case}
                        {case}
                            <input type="hidden" name="on0" value="{$on0}">
                            <input type="hidden" name="os0" value="{$os0}"> 
                        {/case}
                        {/switch}
    </div>
    <div style="float:left;margin:5px;">
                        {switch match=$os1_type}
                        {case match='select'}
                        <label>{$on1}</label><br />
                        <input type="hidden" name="on1" value="{$on1}">
                        <select name="os1">
                            {section loop=$os1|explode(ezini('PayPalSettings','Delimiter','customtag.ini'))}
                                <option value="{$:item}">{$:item}</option>
                            {/section}
                        </select>
                        {/case}
                        {case match='input'}
                            <label>{$on1}</label><br />
                            <input type="hidden" name="on0" value="{$on1}">
                            <input name="os1" type="text" value="{$os1}" size="10" maxlength="60">
                        {/case}
                        {case}
                            <input type="hidden" name="on1" value="{$on1}">
                            <input type="hidden" name="os1" value="{$os1}"> 
                        {/case}
                        {/switch}
    </div>
    <div style="float:left;margin:5px;">
        <input type="image" src="{$image}" border="0" name="submit" alt="{$image_alt}">
    </div>
                    <input type="hidden" name="cmd" value="{$cmd}">
                    <input type="hidden" name="business" value="{$business}">
                    <input type="hidden" name="item_name" value="{$item_name}">
                    <input type="hidden" name="item_number" value="{$item_number}">
                    <input type="hidden" name="no_note" value="{$no_note}">
                    <input type="hidden" name="currency_code" value="{$currency_code}">
                    
                    <input type="hidden" name="a3" value="{$a3}">
                    <input type="hidden" name="p3" value="{$p3}">
                    <input type="hidden" name="t3" value="{$t3}">
                    <input type="hidden" name="src" value="{$src}">
                    <input type="hidden" name="sra" value="{$sra}">
</fieldset>
</form>
{/default}
</div>
