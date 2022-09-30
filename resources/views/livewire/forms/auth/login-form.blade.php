<div class="w-full bg-white rounded-lg overflow-hidden border border-gray-200 sm:max-w-md flex flex-col divide-y">
    <div class="flex justify-between gap-4 px-6 py-4">
        <h4 class="font-semibold text-center w-full">Sign in to your account</h4>
    </div>
    <div class="px-6 py-6 space-y-4">
        <form wire:submit.prevent="" class="grid grid-cols-1 gap-4" action="#">
            <div class="grid grid-cols-1 gap-4 mb-2">
                <x-input label="Email address" placeholder="Enter email address" wire:model="email" />
                <x-input label="Password" type="password" placeholder="Enter password" wire:model="password" />
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-start">
                    <x-checkbox label="Remember Me" wire:model="rememberMe" />
                </div>
            </div>
        </form>
    </div>
    <div class="flex justify-between gap-4 px-6 py-4 bg-gray-50">
        <x-button wire:click="performLogin" spinner="performLogin" primary class="w-full" label="Sign In" />
    </div>

    <x-dialog />
</div>
