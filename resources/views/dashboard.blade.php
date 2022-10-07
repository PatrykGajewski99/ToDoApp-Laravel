<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Lists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Category Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @include('message')
                            @foreach($lists as $list)
                                <tr>
                                <td>
                                    {{$list->list_name}}
                                </td>
                                <td>
                                    <a href="{{url('add-task/'.$list->id)}}" style="background: #1c7430;padding: 5px 20px;border-radius: 25px;margin-right: 10px;margin-left: 150px">Add task</a>
                                </td>
                                <td>
                                    <form action="{{url('delete-list/'.$list->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" style="background: red;padding:  5px 20px;border-radius: 25px;margin-right: 10px">Delete</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{url('edit-list/'.$list->id)}}" style="background: yellowgreen;padding:  5px 20px;border-radius: 25px;margin-right: 10px">EDIT</a>
                                </td>
                                <td>
                                    <a href="{{url('show-task/'.$list->id)}}" style="background: dodgerblue;padding: 5px 20px;border-radius: 25px;margin-right: 10px">Show tasks</a>
                                </td>


                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
