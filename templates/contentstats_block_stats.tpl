{*  $Id: contentstats_block_pending.tpl  *}
{if $numPendingItems gt 0}
<ul>
    {section name="items" loop=$statsitems}
    <li> 
		{if $statsitems[items].img != "" }
		<img src="{$imagespath|safehtml}/{$statsitems[items].img|safehtml}" />
		{/if}
        <a href="{$statsitems[items].url}">{$statsitems[items].name}</a>
        (<span>{$statsitems[items].number}</span>)
    </li>
    {/section}
</ul>
{/if}
