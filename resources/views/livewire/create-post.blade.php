<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    {{-- boton rojo - Crear Post --}}
    <x-jet-danger-button wire:click="$set('open', true)">
        Crear post
    </x-jet-danger-button>

    {{-- Ventana Modal para Crear Post --}}
    <x-jet-dialog-modal wire:model='open'>

        <x-slot name='title'>
            Crear nuevo post
        </x-slot>

        <x-slot name='content'>

            {{-- tailwind alert, para avisar al user que se esta subiendo una imagen --}}
            <div wire:loading wire:target='image' class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Cargando imagen!</strong>
                <span class="sm:inline">Espere un momento ...</span>
            </div>

            {{-- Cada vez que se selecciona una imagen en el input de input type="file", se almacena una imagen temporal en temporaryUrl() que se encuentra real en path /storage/app/livewire-tmp  --}}
            @if ($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}">
                {{ sleep(1) }} 
            @endif

            {{-- Titulo del post --}}
            <div class="mb-4">
                <x-jet-label value="Título del Post"></x-jet-label>
                <x-jet-input type="text" class="w-full" wire:model="title"></x-jet-input>
                <x-jet-input-error for='title' />
            </div>

            {{-- Contenido del post --}}
            <div class="mb-4">
                <x-jet-label value="Contenido del Post"></x-jet-label>
                <div wire:ignore>
                    <textarea id="editor" wire:model.defer="content" class="form-control w-full" rows="6">{{ $content }}</textarea>
                </div>
                <x-jet-input-error for='content' />
            </div>

            {{-- imagen del post --}}
            <div>
                <input type="file" wire:model='image' id="{{ $idinputimagen }}">
                <x-jet-input-error for='image' />
            </div>
             {{-- Cualquier imagen que seleccionemos en este input sera almacenada en la propiedad image, gracias al wire:model='image' --}}

        </x-slot>

        <x-slot name='footer'>

            <x-jet-secondary-button class="mr-2" wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target='save, image'
                class="disabled:opacity-25">
                Crear Post
            </x-jet-danger-button>
            {{-- solo mostrar span cuando se esta ejecutando el método save --}}
            {{-- <span wire:loading wire:target='save'>Cargando ...</span> --}}

        </x-slot>

    </x-jet-dialog-modal>

    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

        {{-- inicializar pulgin https://ckeditor.com/docs/ckeditor5/latest/builds/guides/quick-start.html --}}
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .then(function(editor){
                    
                    editor.model.document.on('change:data', () => {
                        @this.set('content', editor.getData());    
                    });

                    Livewire.on('resetCKEditor', () => {
                        editor.setData('');
                    });

                })
                .catch( error => {
                    console.error( error );
                } );
        </script>

    @endpush

</div>
