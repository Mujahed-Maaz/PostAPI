<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Hello, {{ $name }} . <br>
                    {{ __("You're logged in!") }}
                    {{ __("Here is your tokens") }}
                    <h3>Your API Tokens</h3>
                    <br>
                    <ul>
                        <li>
                            <strong> Admin Token </strong> <br>
                            <strong>Abilities:</strong> {{ implode(', ', $tokens[0]->abilities) }} <br>
                            <strong>Token:</strong> {{ $admin }}
                        </li>
                        <br>
                        <li>
                            <strong> Author Token </strong> <br>
                            <strong>Abilities:</strong> {{ implode(', ', $tokens[1]->abilities) }} <br>
                            <strong>Token:</strong> {{ $author }}
                        </li>
                        <br>
                        <li>
                            <strong> Viewer Token </strong> <br>
                            <strong>Abilities:</strong> {{ implode(', ', $tokens[2]->abilities) }} <br>
                            <strong>Token:</strong> {{ $viewer }}
                        </li>
                        <br>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>