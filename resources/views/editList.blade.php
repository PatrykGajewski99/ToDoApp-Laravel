<x-app-layout>
    <x-guest-layout>
        <x-auth-card>
            <x-slot name="logo">
                <img src="https://icons.veryicon.com/png/o/miscellaneous/linear-small-icon/edit-246.png" style="width: 200px"/>
            </x-slot>
            <div name="title" style="text-align: center;font-size: 40px">Edit List Name</div>
            <form action="{{url('update-list/'.$list->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <!-- Name -->
                <div>
                    <x-input-label for="list_name" :value="__('Name')" />

                    <x-text-input id="list_name" class="block mt-1 w-full" type="text" name="list_name" :value="$list->list_name" required autofocus />

                    <x-input-error :messages="$errors->get('list_name')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('UPDATE') }}
                    </x-primary-button>
                </div>
            </form>
            @include('message')
        </x-auth-card>
    </x-guest-layout>

</x-app-layout>

