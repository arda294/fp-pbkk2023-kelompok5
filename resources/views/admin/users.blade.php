@extends('app-layout')

@section('main')
<div class="flex flex-col gap-3 p-4 min-h-full w-full bg-green-50">
    <span class="text-2xl font-extrabold">Halo {{ Auth::user()->name }}! </span>
    <section class="flex flex-col gap-2">
        <div class="flex gap-2">
            <span class="text-2xl font-extrabold my-2"> All Users </span>
            <form class="flex items-center gap-2 flex-grow justify-end"> 
                <input type="text" class="p-2 border rounded-md w-50" name="search">
                <button type="submit" class="flex gap-2 bg-green-500 rounded-md p-2 items-center justify-center">
                    <x-heroicon-o-magnifying-glass class="h-5 text-white"/>
                </button>
            </form>
        </div>
        @if ($message = session('success'))
        <span class="flex flex-row bg-green-200 rounded-md ring-1 ring-green-900 text-green-900 p-4" onclick="">
            {{ $message }} <button class="ml-auto font-extrabold" onclick="this.parentNode.remove()">X</button>
        </span>
        @endif
        <div class="bg-white shadow-md p-4 rounded-md">
            <div class="flex flex-col min-h-[10rem] gap-2">
                @if ($users->count() == 0)
                <div class="flex flex-col gap-4 self-center my-auto">
                    <span class="self-center text-gray-500 text-lg"> You don't have any products for sale yet... </span>
                    <button class="self-center bg-green-400 text-white p-2 rounded-md">Add Product</button>
                </div>
                @else
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 ">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Id
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Location
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Banned
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Deleted
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Products
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Incoming Orders
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Orders
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">View</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr class="bg-white border-b ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{$user->id}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{$user->name}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$user->region->name}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->is_banned ? 'Yes' : 'No'}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->is_deleted ? 'Yes' : 'No'}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->products_count}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->incoming_orders_count}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$user->orders_count}}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{url('admin/user/' . $user->id . '/edit')}}" class="font-medium text-blue-600  hover:underline">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                {{$users->links()}}
            </div>
        </div>
    </section>
</div>
@endsection
