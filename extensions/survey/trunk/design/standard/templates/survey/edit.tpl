<form enctype="multipart/form-data" method="post" action={concat("/survey/edit/",$survey.id)|ezurl}>

<input type="hidden" name="SurveyID" value="$survey.id" />

<table class="layout" border="0" cellspacing="0" cellpadding="5">

<tr>
    <td colspan="2">
    <div class="maincontentheader">
    <h1>{"Edit Survey"|i18n( 'survey' )} '{$survey.title}'</h1>
    {include uri="design:survey/edit_validation.tpl"}
    </div>
    </td>
</tr>

<tr>
    <td valign="top">
    <label>{'Survey title'|i18n( 'survey' )}</label><div class="labelbreak"></div>
    <input type="text" name="SurveyTitle" value="{$survey.title}" size="70">
    </td>
    <td valign="top" align="center">
    <label>{'Enabled'|i18n( 'survey' )}</label><div class="labelbreak"></div>
    <input type="checkbox" name="SurveyEnabled" {section show=$survey.enabled|eq(1)}checked{/section} />
    </td>
</tr>

<tr>
    <td>
    &nbsp;
    </td>
    <td align="center">
    <label>{'Order'|i18n( 'survey' )}</label><br />
    <label>{'Selected'|i18n( 'survey' )}</label>
    </td>
</tr>

{section name=Question loop=$survey_questions sequence=array(bgdark,bglight)}
<tr class={$:sequence}>
    <td valign="top">
    <input type="hidden" name="SurveyQuestionList[]" value="{$:item.id}" />
    {survey_question_edit_gui question=$:item}
    </td>
    <td valign="top" align="center">
    <input type="input" size="2" name="SurveyQuestionTabOrder_{$:item.id}" value="{$:item.tab_order}" />&nbsp;<input name="SurveyQuestion_{$:item.id}_Selected" type="checkbox" />
    </td>
</tr>
{/section}

<tr>
    <td colspan="2" valign="bottom" height="50">    
    <select name="SurveyNewQuestionType">
    {section var=type loop=$survey.question_types}
        <option value="{$type.type}">{$type.name}</option>
    {/section}
    </select>
    <input class="button" type="submit" name="SurveyNewQuestion" value="{'Add question'|i18n( 'survey' )}" />
    &nbsp;&nbsp;
    <input class="button" type="submit" name="SurveyRemoveSelected" value="{'Remove selected'|i18n( 'survey' )}" />
    </td>
</tr>

<tr>
    <td colspan="2" valign="bottom" height="70">
    <div class="buttonblock">
    <input class="defaultbutton" type="submit" name="SurveyPublishButton" value="{'Publish'|i18n( 'survey' )}" />
    <input class="button" type="submit" name="SurveyApplyButton" value="{'Apply'|i18n( 'survey' )}" />
    <input class="button" type="submit" name="SurveyDiscardButton" value="{'Discard'|i18n( 'survey' )}" />
    </div>
    </td>
</tr>

</table>

</form>
