<div class="card" id="main_item">
    <div class="card-header">
        Spotlights (<div style="display:inline;" id="item_count">{if !$spotlights}0{else}{count($spotlights)}{/if}</div>)
        <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md pull-right" href="javascript:void(0)" onClick="Spotlight.add()">Create Spotlight</a>
    </div>

    <div class="card-body">
        {if $spotlights}
            <table class="table table-responsive-md table-hover">
                <thead>
                    <tr>
                        <th>Sort</th>
                        <th>Title</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody id="ItemTableResult">
                {foreach from=$spotlights item=row}
                    <tr>
                        <td>
                            <a href="javascript:void(0)" onClick="Spotlight.move('up', {$row.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Move up"><i class="fa-duotone fa-up-from-bracket"></i></a>
                            <a href="javascript:void(0)" onClick="Spotlight.move('down', {$row.id}, this)" data-bs-toggle="tooltip" data-bs-placement="top" title="Move down"><i class="fa-duotone fa-down-to-bracket"></i></a>
                        </td>

                        <td>{$row.title}</td>

                        <td style="text-align:center;">
                            <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="javascript:void(0)" onClick="Spotlight.remove({$row.id}, this)">Delete</a>

                            <a class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md" href="{$url}sidebox_spotlight/admin/edit/{$row.id}">Edit</a>
                        </td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        {/if}
    </div>
</div>

<div class="card" id="add_item" style="display:none;">
    <div class="card-header"><h2><a href='javascript:void(0)' onClick="Spotlight.add()">Spotlights</a> &rarr; New Spotlight</h2></div>
    <div class="card-body">
        <form onSubmit="Spotlight.create(this); return false" id="submit_form">
            <label class="col-sm-2 col-form-label" for="image">Title</label>
            <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="title" id="title"/>

            <label class="col-sm-2 col-form-label" for="image">Image</label>
            <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="image" id="image"/>

            <label class="col-sm-2 col-form-label">Contents </label>
            <input class="form-control nui-focus border-muted-300 text-muted-600 placeholder:text-muted-300 dark:border-muted-700 dark:bg-muted-900/75 dark:text-muted-200 dark:placeholder:text-muted-500 dark:focus:border-muted-700 peer w-full border bg-white font-monospace transition-all duration-300 disabled:cursor-not-allowed disabled:opacity-75 px-2 h-10 py-2 text-sm leading-5 px-3 rounded" type="text" name="contents" id="contents"/>

            <button type="submit" class="relative font-sans font-normal text-sm inline-flex items-center justify-center leading-5 no-underline h-8 px-3 py-2 space-x-1 border nui-focus transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed hover:enabled:shadow-none text-muted-700 border-muted-300 dark:text-white dark:bg-muted-700 dark:border-muted-600 dark:hover:enabled:bg-muted-600 hover:enabled:bg-muted-50 dark:active:enabled:bg-muted-700/70 active:enabled:bg-muted-100 rounded-md mt-2">Submit Spotlight</button>
        </form>
    </div>
</div>