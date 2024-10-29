<?php
    use function Laravel\Folio\{middleware, name};
    use Livewire\Attributes\Validate;
    use Livewire\Volt\Component;
    middleware('subscribed');
    name('projects.create');

    new class extends Component
    {
        #[Validate('required|min:3|max:255')]
        public string $name = '';

        public function save(): void
        {
            $validated = $this->validate();

            $project = auth()->user()->projects()->create($validated);

            session()->flash('message', 'Project created successfully.');

            $this->redirect(route('projects'));
        }
    }
?>

<x-layouts.app>
    @volt('projects.create')
        <x-app.container>

            <x-elements.back-button
                class="max-w-full mx-auto mb-3"
                text="Back to Projects"
                :href="route('projects')"
            />

            <div class="flex items-center justify-between mb-3">
                <x-app.heading
                        title="New Project"
                        description=""
                        :border="false"
                    />
            </div>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Project name</label>
                    <input type="text" id="name" wire:model="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-button type="submit">
                        Create Project
                    </x-button>
                </div>
            </form>
        </x-app.container>
    @endvolt
</x-layouts.app>
