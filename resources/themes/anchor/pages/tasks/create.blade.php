<?php

use Illuminate\Support\Collection;
use function Laravel\Folio\{middleware, name};
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

middleware('auth');
name('tasks.create');

new class extends Component {
    #[Validate('required|min:3|max:255')]
    public string $name = '';

    #[Validate('required|integer|exists:projects,id')]
    public int $project_id;

    public function with(): array
    {
        return [
            'projects' => auth()->user()->projects()->pluck('name', 'id'),
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $task = auth()->user()->tasks()->create($validated);

        session()->flash('message', 'Task created successfully.');

        $this->redirect(route('tasks'));
    }
}
?>

<x-layouts.app>
    @volt('tasks.create')
    <x-app.container>

        <x-elements.back-button
            class="max-w-full mx-auto mb-3"
            text="Back to Tasks"
            :href="route('tasks')"
        />

        <div class="flex items-center justify-between mb-3">
            <x-app.heading
                title="New Task"
                description=""
                :border="false"
            />
        </div>

        <form wire:submit="save" class="space-y-4">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Task name</label>
                <input type="text" id="name" wire:model="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <label for="project_id" class="block mb-2 text-sm font-medium text-gray-700">Project</label>
                <select id="project_id" name="project_id" wire:model.live="project_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option>-- SELECT PROJECT --</option>
                    @foreach($projects as $id => $project)
                        <option value="{{ $id }}">{{ $project }}</option>
                    @endforeach
                </select>
                @error('project_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
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
