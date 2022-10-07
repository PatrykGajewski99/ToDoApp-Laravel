<x-app-layout>
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <img src="https://www.creativefabrica.com/wp-content/uploads/2019/05/Add-icon-by-ahlangraphic-1-580x386.jpg" style="width: 200px"/>
            </x-slot>
            <div name="title" style="text-align: center;font-size: 40px">Add Task Name</div>
            <form method="POST" action="{{url('add-task/'.$listID)}}">
                @csrf
                <!-- Name -->
                <div>
                    <x-input-label for="task_name" :value="__('Name')" />

                    <x-text-input id="task_name" class="block mt-1 w-full" type="text" name="task_name" :value="old('task_name')" required autofocus />

                    <x-input-error :messages="$errors->get('task_name')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('ADD') }}
                    </x-primary-button>
                </div>
            </form>
            @include('message')
            <form method="GET" action="{{route('dashboard')}}">
                <x-primary-button class="ml-4">
                    {{ __('BACK') }}
                </x-primary-button>
            </form>
        </x-auth-card>
    </x-guest-layout>

</x-app-layout>

