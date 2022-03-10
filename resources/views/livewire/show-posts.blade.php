<div wire:init='loadPosts'>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-table>

            <div class="px-2 py-4 flex items-center">
                <div class="flex items-center">
                    <span class="mr-2">Mostrar</span>
                    <select class="mr-2 form-control" wire:model='cant'>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="mr-2">entradas</span>
                </div>
                <x-jet-input class="flex-1 mr-2" placeholder="Escriba lo que quiera buscar" type="text" wire:model='search'></x-jet-input>
                @livewire('create-post')
            </div>

            @if (count($posts))

                <table class="table-auto w-full">

                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                        <tr>
                            <th class="px-4 whitespace-nowrap">
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

                        @foreach ($posts as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{ $item->title }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        {{-- {{ $item->content }} --}}
                                        {!! $item->content !!}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium flex">
                                    
                                    {{-- botón verde Editar --}}
                                    <a class="btn btn-green" wire:click="edit({{ $item }})">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- botón rojo Eliminar --}}
                                    <a class="btn btn-red ml-2" 
                                        wire:click="$emit('deletePost', {{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>

                @if ($posts->hasPages())
                    <div class="px-6 py-3">
                        {{ $posts->links() }}
                    </div>    
                @endif

            @else
                <div class="px-4 py-3">
                    @if ($readyToLoad == false)
                        Cargando, favor de esperar ... <br>
                        <i class="fas fa-spinner"></i>
                    @else
                        No existe ningún registro coincidente.
                    @endif
                </div>
            @endif

        </x-table>
    </div>

    <x-jet-dialog-modal wire:model="open_edit">

        <x-slot name='title'>
            {{-- Editar el post - {{ $post->title }} --}}
            Editar el post
        </x-slot>

        <x-slot name='content'>

            {{-- tailwind alert, para avisar al user que se esta subiendo una imagen --}}
            <div wire:loading wire:target='image' class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Cargando imagen!</strong>
                <span class="sm:inline">Espere un momento ...</span>
            </div>

            @if ($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}">
                {{ sleep(1) }}
            @else
                <img src="{{ Storage::url($post->image) }}">
            @endif

            {{-- Título del post --}}
            <div class="mb-4">
                <x-jet-label value="Título del post" />
                <x-jet-input wire:model="post.title" type="text" class="w-full" />
            </div>

            {{-- Contenido del post --}}
            <div>
                <x-jet-label value="Contenido del post" />
                <textarea wire:model="post.content" rows="6" class="form-control w-full"></textarea>
            </div>

            {{-- imagen --}}
            <div>
                <input type="file" wire:model='image' id="{{ $idinputimagen }}">
                <x-jet-input-error for='image' />
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-secondary-button wire:click="$set('open_edit', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="update" wire:loading.attr='disabled' class="ml-2 disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>

    @push('js')

        <script src="sweetalert2.all.min.js"></script>

        <script>
            Livewire.on('deletePost', postId => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('show-posts', 'delete', postId);

                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                    }
                })
            });
        </script>

    @endpush

</div>
