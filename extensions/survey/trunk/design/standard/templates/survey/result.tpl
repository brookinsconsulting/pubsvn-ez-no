<h1>{$survey.title}</h1>

{section var=question loop=$survey_questions}
<div class="block">
{survey_question_result_gui view=overview question=$question metadata=$survey_metadata}
<br />
</div>
{/section}
