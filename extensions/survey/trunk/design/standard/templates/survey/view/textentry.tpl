{$question.number}. {$question.text}<br />
<table border="0" cellspacing="0" cellpadding="0"><tr><td width="50">&nbsp;</td><td>
{switch match=$question.num2}
{case match=1}
<input name="SurveyAnswer_{$question.id}" type="text" size="{$question.num}" value="{$question.answer}" />
{/case}
{case}
<textarea name="SurveyAnswer_{$question.id}" rows="{$question.num2}" cols="{$question.num}">{$question.answer}</textarea>
{/case}
{/switch}
</td></tr></table>
<br />