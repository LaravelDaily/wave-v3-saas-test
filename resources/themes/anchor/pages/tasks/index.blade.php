<?php

use Illuminate\Support\Collection;
use function Laravel\Folio\{middleware, name};
use App\Models\Project;
use Livewire\Volt\Component;

middleware('auth');
name('tasks');

new class extends Component {
    public Collection $tasks;

    public function mount(): void
    {
        $this->tasks = auth()->user()->tasks()->with('project')->latest()->get();
    }

    public function deleteProject(Project $project): void
    {
        $project->delete();

        $this->tasks = auth()->user()->tasks()->latest()->get();
    }
}
?>

<x-layouts.app>
    @volt('tasks')
    <x-app.container>

        <div class="flex items-center justify-between mb-5">
            <x-app.heading
                title="Tasks"
                description="Check out your tasks below"
                :border="false"
            />
            <x-button tag="a" href="/tasks/create">New Task</x-button>
        </div>

        @if($tasks->isEmpty())
            <div class="w-full p-20 text-center bg-gray-100 rounded-xl">
                <p class="text-gray-500">You don't have any tasks yet.</p>
            </div>
        @else
            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full bg-white">
                    <thead class="text-sm bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Project</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="px-4 py-2">{{ $task->name }}</td>
                                <td class="px-4 py-2">{{ $task->project->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <a href="/project/edit/{{ $task->id }}" class="mr-2 text-blue-500 hover:underline">Edit</a>
                                    <button wire:click="deleteProject({{ $task->id }})" class="text-red-500 hover:underline">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-app.container>
    @endvolt
</x-layouts.app>
