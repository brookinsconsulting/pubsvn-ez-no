<h2>{"Text entry"|i18n( 'survey' )}</h2>

<div class="block">
<label>{"Number of columns for an answer textarea"|i18n( 'survey' )}</label>
<input type="text" name="SurveyQuestion_{$question.id}_Num" value="{$question.num}" size="3" />

<label>{"Number of rows"|i18n( 'survey' )}</label>
<input type="text" name="SurveyQuestion_{$question.id}_Num2" value="{$question.num2}" size="3" />
<br/>

<label>{"Text of question"|i18n( 'survey' )}</label><div class="labelbreak"></div>
<input type="text" name="SurveyQuestion_{$question.id}_Text" value="{$question.text}" size="70" />
</div>
