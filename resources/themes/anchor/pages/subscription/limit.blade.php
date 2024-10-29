<?php

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\mount;

name('limit');
middleware('auth');

mount(function () {
    if (auth()->user()->hasRole('pro')) {
        $this->redirect('/dashboard');
    }
})
?>

<x-layouts.app>
    <x-app.container x-data class="space-y-6" x-cloak>
        <div class="w-full">
            <x-app.heading
                    title="Free Plan Limit"
            />
            <div class="py-5 space-y-5">
                <p>
                    You have hit free plan limit for 10 tasks. Consider upgrading.
                </p>

                <x-marketing.sections.pricing />
            </div>
        </div>
    </x-app.container>
</x-layouts.app>