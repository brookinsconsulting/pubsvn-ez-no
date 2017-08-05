{default te_limit=5}
{$question.number}. {$question.text}<br />

<table border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="50">&nbsp;</td>
  <td>
  {"Last answers"|i18n( 'survey' )}
  <ul>
  {let results=fetch('survey','text_entry_result',hash( 'question', $question, 'metadata', $metadata, 'limit', $te_limit ))}
  {section var=result loop=$results}
    <li>{$result.value}</li>
  {/section}
  {/let}
  </ul>
  </td>
</tr>
</table>
<br />
{/default}
