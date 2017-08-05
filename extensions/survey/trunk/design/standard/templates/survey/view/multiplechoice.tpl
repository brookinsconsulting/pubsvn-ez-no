{$question.number}. {$question.text}<br />
<table border="0" cellspacing="0" cellpadding="0"><tr><td width="50">&nbsp;</td><td>
{switch match=$question.num}
{case match=1}
{section var=option loop=$question.options}
  <input name="SurveyAnswer_{$question.id}" type="radio" value="{$option.value}"{section show=$option.toggled|eq(1)} checked{/section}>{$option.label}&nbsp;&nbsp;
{/section}
{/case}
{case match=2}
{section var=option loop=$question.options}
  <input name="SurveyAnswer_{$question.id}" type="radio" value="{$option.value}"{section show=$option.toggled|eq(1)} checked{/section}>{$option.label}<br />
{/section}
{/case}
{case match=3}
{section var=option loop=$question.options}
  <input name="SurveyAnswer_{$question.id}[]" type="checkbox" value="{$option.value}"{section show=$option.toggled|eq(1)} checked{/section}>{$option.label}&nbsp;&nbsp;
{/section}
{/case}
{case match=4}
{section var=option loop=$question.options}
  <input name="SurveyAnswer_{$question.id}[]" type="checkbox" value="{$option.value}"{section show=$option.toggled|eq(1)} checked{/section}>{$option.label}<br />
{/section}
{/case}
{case match=5}
<select name="SurveyAnswer_{$question.id}">
  {section var=option loop=$question.options}
    <option value="{$option.value}"{section show=$option.toggled|eq(1)} selected{/section}>{$option.label}</option>
  {/section}
</select>
{/case}
{/switch}
</td></tr></table>
<br />
