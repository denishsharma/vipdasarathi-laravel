<div>
    <nav>
        <div class="mx-auto px-2 sm:px-6 lg:px-20">
            <div {{ $attributes->merge(['class' => 'relative flex items-center justify-between gap-10 h-16']) }}>
                {{ $slot }}
            </div>
        </div>
    </nav>
    <div class="bg-gray-100 h-px"></div>
</div>
