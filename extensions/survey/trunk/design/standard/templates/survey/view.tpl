<form enctype="multipart/form-data" method="post" action={$post_action|ezurl}>

<input type="hidden" name="SurveyID" value="$survey.id" />

<h1>{$survey.title}</h1>

{include uri="design:survey/view_validation.tpl"}

{section var=question loop=$survey_questions}
<div class="block">
<input type="hidden" name="SurveyQuestionList[]" value="{$question.id}" />
{survey_question_view_gui question=$question}
<br />
</div>
{/section}

<div class="buttonblock">
<input class="defaultbutton" type="submit" name="SurveyStoreResult" value="Send" />
<input class="button" type="submit" name="SurveyCancelButton" value="Avbryt" />
</div>
