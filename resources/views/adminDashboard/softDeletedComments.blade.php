<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Welcome to the admin dashboard!') }}
                    {{ __('You can manage see soft deleted Comments from here.') }}
                    <ul>
                        @foreach ($softDeletedComments as $softDeletedComment)
                        <li>{{ $softDeletedComment->title }}</li>
                        <li>{{ $softDeletedComment->body }}</li>
                        <li>{{ $softDeletedComment->deleted_at }}</li>
                        @endforeach

                        <!-- show soft deleted Comment! -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>