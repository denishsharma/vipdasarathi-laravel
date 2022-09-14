@if ($start)
    <li class="inline-flex items-center">
        <a href="{{ $href }}" class="{{ $active ? 'text-gray-700 dark:text-gray-400' : 'text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white' }} inline-flex items-center text-sm font-medium">
            <x-icon class="w-4 h-4 mr-1 mb-0.5" name="{{ $icon }}" solid />
            {{ $label }}
        </a>
    </li>
@else
    @if ($type == 'link')
        <li>
            <div class="flex items-center">
                <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                <a href="{{ $href }}" class="{{ $active ? 'text-gray-700 dark:text-gray-400' : 'text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white' }} ml-1 text-sm font-medium md:ml-2">
                    {{ $label }}
                </a>
            </div>
        </li>
    @else
        <li>
            <div class="flex items-center">
                <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                <span class="{{ $active ? 'text-gray-700 dark:text-gray-400' : 'text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white' }} ml-1 text-sm font-medium md:ml-2">
                    {{ $label }}
                </span>
            </div>
        </li>
    @endif
@endif
