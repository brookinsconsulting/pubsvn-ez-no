{section show=or( $survey_validation.error, $survey_validation.warning )}
<div class="warning">
<h2>{"Warning"|i18n( 'survey' )}</h2>
<ul>
{section var=error loop=$survey_validation.errors}
  <li>
  {switch match=$error.code}
  {case match='EZSURVEY_ERROR_NOT_UNIQUE_OPTIONS'}
  {"Options of multiple choice question <i>%question</i> must have unique values!"|i18n( 'survey', '', hash( '%question', $error.argument ) )}
  {/case}
  {case match='EZSURVEY_ERROR_NO_OPTION'}
  {"You must enter at least one option of multiple choice question <i>%question</i>!"|i18n( 'survey', '', hash( '%question', $error.argument ) )}
  {/case}
  {case}
  {"Unknown warning or error."|i18n( 'survey' )}
  {/case}
  {/switch}
  </li>
{/section}
{section var=warning loop=$survey_validation.warnings}
  <li>
  {switch match=$warning.code}
  {case}
  {"Unknown warning or error."|i18n( 'survey' )}
  {/case}
  {/switch}
  </li>
{/section}
</ul>
</div>
<br/ >
{/section}