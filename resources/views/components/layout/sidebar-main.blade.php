<div class="mx-auto px-20 py-10">
    <div class="mx-auto px-20 py-10">
        <div class="mx-auto grid overflow-hidden grid-cols-4 grid-rows-1 gap-10 lg:w-10/12 sm:w-auto">
            <div class="row-end-auto col-start-1 grid grid-cols-1 gap-5">
                {{ $sidebar }}
            </div>
            <div class="row-end-auto col-start-2 col-span-3 h-fit">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
