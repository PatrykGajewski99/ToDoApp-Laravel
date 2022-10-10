<x-app-layout>
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <img src="https://icons.veryicon.com/png/o/miscellaneous/linear-small-icon/edit-246.png" style="width: 200px"/>
            </x-slot>
            <div name="title" style="text-align: center;font-size: 40px">Edit Task</div>
            <form action="{{url('update-task/'.$task->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <!-- Name -->
                <div>
                    <x-input-label for="task_name" :value="__('Name')" />

                    <x-text-input id="task_name" class="block mt-1 w-full" type="text" name="task_name" :value="$task->task_name" required autofocus />

                    <x-input-error :messages="$errors->get('task_name')" class="mt-2" />
                </div>
                <!-- Status -->
                <div>
                    <x-input-label for="status" :value="__('Status')" />

                    <select name="status" id="status">
                        <option value="to-do">to-do</option>
                        <option value="in-progress">in-progress</option>
                        <option value="done">done</option>
                    </select>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('UPDATE') }}
                    </x-primary-button>
                </div>
            </form>
            @include('message')
            <form method="GET" action="{{route( 'dashboard') }}">
                <x-primary-button class="ml-4">
                    {{ __('BACK') }}
                </x-primary-button>
                </div>
            </form>
        </x-auth-card>
    </x-guest-layout>

</x-app-layout>

