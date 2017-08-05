
<form enctype="multipart/form-data" method="post" action={"/survey/list"|ezurl}>

<h1>{"Survey List"|i18n('survey')}</h1>

<table class="list" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
  <th>{"Survey title"|i18n('survey')}</th>
  <th>{"Enabled"|i18n('survey')}</th>
  <th>{"Published"|i18n('survey')}</th>
  <th>{"Actions"|i18n('survey')}</th>
</tr>
{section name=Survey loop=$survey_list sequence=array('bglight','bgdark')}
<tr class="{$:sequence}">
  <td>{section show=$:item.published|eq(1)}
           <a href={concat('survey/view/', $:item.id)|ezurl}>{$:item.title}</a> <a href={concat('survey/result/', $:item.id)|ezurl}>[results]</a>
      {section-else}
           {$:item.title}
      {/section}</td>
  <td>
    {switch match=$:item.enabled}
      {case match=0}{"not enabled"|i18n('survey')}{/case}
      {case match=1}{"enabled"|i18n('survey')}{/case}
    {/switch}
  </td>
  <td>
    {switch match=$:item.published}
      {case match=0}{"not published"|i18n('survey')}{/case}
      {case match=1}{"published"|i18n('survey')}{/case}
    {/switch}
  <td>
  {section show=$:item.published|eq(0)}
  <a href={concat("/survey/edit/",$:item.id)|ezurl}><img src={"edit.png"|ezimage} border="0" title="{"Edit"|i18n('survey')}" /></a>
  {/section}
  <a href={concat("/survey/copy/",$:item.id)|ezurl}><img src={"copy.gif"|ezimage} border="0" title="{"Copy and edit"|i18n('survey')}" /></a>
  </td>
</tr>
{/section}
</table>

<div class="buttonblock">
<input class="defaultbutton" type="submit" name="SurveyNewSurveyButton" value="{'New Survey'|i18n( 'survey' )}" />
</div>

</form>