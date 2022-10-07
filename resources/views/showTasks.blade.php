<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My tasks') }}
        </h2>
    </x-slot>
    </table>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table style="width: 50%;" class="table table-striped table-bordered text-center table-hover table-responsive">
                        <thead>
                        <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @include('message')
                        @foreach($tasks as $task)
                            <tr>
                                <td>
                                    {{$task->task_name}}
                                </td>
                                <td>
                                    {{$task->status}}
                                </td>
                                <td>
                                    <form action="{{url('delete-task/'.$task->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" style="background: red;padding:  5px 20px;border-radius: 25px;margin-right: 10px">Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{url('edit-task/'.$task->id)}}" style="background: yellowgreen;padding:  5px 20px;border-radius: 25px;margin-right: 10px">EDIT</a>
                                </td>


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <form method="GET" action="{{route('dashboard')}}">
                        <x-primary-button class="ml-4">
                            {{ __('BACK') }}
                        </x-primary-button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
