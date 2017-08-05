{$question.number}. {$question.text}<br />

<table border="0" cellspacing="1" cellpadding="0">
<tr>
  <td width="50">&nbsp;</td>
  <td>{"Value"|i18n('survey')}&nbsp;</td>
  <td>{"Count"|i18n('survey')}&nbsp;</td>
  <td colspan="2">{"Percentage"|i18n('survey')}&nbsp;</td>
</tr>
{let results=fetch('survey','multiple_choice_result',hash( 'question', $question, 'metadata', $metadata ))}
{* section var=result loop=$question.result *}
{section var=result loop=$results}
<tr>
  <td width="50">&nbsp;</td>
  <td>{$result.value}&nbsp;</td>
  <td>{$result.count}&nbsp;</td>
  <td><table width="101" bgcolor="#e0e0e0" border="0" cellspacing="0" cellpadding="0"><tr><td width="{switch match=$result.percentage}{case match=0}1{/case}{case}{$result.percentage}{/case}{/switch}%" bgcolor="#2070a0"><img alt="" width="1" height="12" src={"1x1.gif"|ezimage} /></td><td><img alt="" src={"1x1.gif"|ezimage} /></td></tr></table></td>
  <td align="right">&nbsp;{$result.percentage}%&nbsp;</td>
  </tr>
{/section}
{/let}
</table>
<br />
