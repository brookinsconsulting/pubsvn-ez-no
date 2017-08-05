<form enctype="multipart/form-data" action={"/csv/csvimport"|ezurl} method="post">

<h1>CSV Import</h1>

<h2>Step 1: Choose import pattern</h2>

<div class="block">
<select name="import_pattern">
{section name=Pattern loop=$pattern_list}
<option value="{$Pattern:item}"{section show=eq($Pattern:item,$import_pattern)}selected="selected"{/section}>{$Pattern:item}</option>
{/section}
</select>
</div>

<h2>Step 2: Upload file</h2>

<div class="block">
<label>{"CSV file"|i18n("design/standard")} ( Max allowed file size is: {round( div( $max_file_size, 1024 ) )} KB )</label>
<div class="labelbreak"></div>
    <input type="hidden" name="MAX_FILE_SIZE" value="{$max_file_size}">
    <input size="35" name="csvfile" type="file">
</div>

<h2>Step 3: Import</h2>

<div class="buttonblock">
<input class="button" type="submit" name="" value="{'Run'|i18n('design/standard')}" />
</div>

{section show=$messages}
    <h2>Log messages</h2>
    <table class="list" border="0" cellpadding="0" cellspacing="1" width="100%">

    {section show=$messages loop=$messages sequence=array( bglight, bgdark)}
        <tr class="{$:sequence}">
            {switch match=$:item.type}
            {case match='Notice'}
                <td width="10%"><font color="green"><b>{$:item.type}</b></font></td>
            {/case}
            {case match='Warning'}
                <td width="10%"><font color="orange"><b>{$:item.type}</b></font></td>
            {/case}
            {case match='Error'}
                 <td width="10%"><font color="red"><b>{$:item.type}</b></font></td>
            {/case}
            {/switch}

            <td>{$:item.function}</td>
            <td>{$:item.message}</td>
    </tr>

   {/section}
   </table>
{/section}

</form>

