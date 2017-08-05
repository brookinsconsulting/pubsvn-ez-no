{let prev=sub($offset,1)
     next=sum($offset,1)}

<h1>{$survey.title}</h1>

{section show=$offset|ne(1)}<a href={concat('survey/rview/',$survey.id,'/',$prev)|ezurl}>{/section}
Previous
{section show=$offset|ne(1)}</a>{/section}
&nbsp;|&nbsp;
{section show=$offset|ne($count)}<a href={concat('survey/rview/',$survey.id,'/',$next)|ezurl}>{/section}
Next
{section show=$offset|ne($count)}</a>{/section}
<br/>

{section var=question loop=$survey_questions}
<div class="block">
{survey_question_result_gui view=item question=$question result_id=$result_id metadata=$survey_metadata}
<br />
</div>
{/section}
{/let}