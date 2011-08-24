

        <legend>Searcher Parameters</legend>
		<!-- Iterando por los parametros del buscador obtenidos-->
		  {foreach from=$params item=param}
		     {assign var=name value=$param[0]}
	         {assign var=type value=$param[1]}
	         {if $type eq "list"}
	            {assign var=opt value=$param[2]}
	            {assign var=select value=$param[3]}

	            {$name}:
	            <select name="{$name}">
	               <option value="-1">---------------------------</option>
	               {html_options options=$opt selected=$select values=$opt}
	            </select>
	               </br>

	         {else}
                {assign var=val value=$param[2]}
		        {$name}: <input type="text" name="{$name}" size="30" value="{$val}"/>
		        </br>

		     {/if}

	      {/foreach}

