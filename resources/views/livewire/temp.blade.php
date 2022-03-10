<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- component tabla de tailwind -->
        <x-table>

            <div class="px-6 py-4 flex items-center">
                {{-- <input type="text" wire:model='search'> --}}
                <x-jet-input class="flex-1 mr-2" placeholder="Escriba lo que quiera buscar" type="text" wire:model='search'></x-jet-input>
                @livewire('create-post')
            </div>

            @if ($posts->count())
                <table class="table-auto w-full">

                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                        <tr>
                            <th class="px-6 whitespace-nowrap">
                                <div class="cursor-pointer font-semibold text-left" wire:click="order('id')">
                                    ID
                                    {{-- sort --}}
                                    @if ($sort == 'id')
                                        @if ($direction == 'asc')
                                            <span style="float:right;"><i class="fas fa-sort-alpha-up-alt"></i>
                                        @else
                                            <span style="float:right;"><i class="fas fa-sort-alpha-down-alt"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort" style="float:right;"></i>
                                    @endif
                                </div>
                            </th>

                            <th class="px-6 whitespace-nowrap">
                                <div class="cursor-pointer font-semibold text-left" wire:click="order('title')">
                                    Título
                                    {{-- sort --}}
                                    @if ($sort == 'title')
                                        @if ($direction == 'asc')
                                            <span style="float:right;"><i class="fas fa-sort-alpha-up-alt"></i>
                                        @else
                                            <span style="float:right;"><i class="fas fa-sort-alpha-down-alt"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort" style="float:right;"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 whitespace-nowrap">
                                <div class="cursor-pointer font-semibold text-left" wire:click="order('content')">
                                    Contenido
                                    {{-- sort --}}
                                    @if ($sort == 'content')
                                        @if ($direction == 'asc')
                                            <span style="float:right;"><i class="fas fa-sort-alpha-up-alt"></i>
                                        @else
                                            <span style="float:right;"><i class="fas fa-sort-alpha-down-alt"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-sort" style="float:right;"></i>
                                    @endif
                                </div>
                            </th>
                            <th class="px-6 whitespace-nowrap">
                                <div class="font-semibold text-center">Edit</div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-100">

                        @foreach ($posts as $post)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->title }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $post->content }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="px-4 py-3">
                    No existe ningún registro coincidente.
                </div>
            @endif

            <div class="px-4 py-3">
                No existe ningún registro coincidente.
            </div>

        </x-table>

    </div>

</div>
