<div class="pkcustomflags">
    {foreach $flags as $flag} 
        <div class="pkcustomflag" style="background-color:{$flag.color};">
            {$flag.name}
        </div>
    {/foreach}
</div>