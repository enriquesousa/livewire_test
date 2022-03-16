# Crea aplicaciones web dinámicas con Laravel Livewire - DataTable
Aprender Livewire creando un DataTable
https://codersfree.com/courses-status/crea-aplicaciones-web-dinamicas-con-laravel-livewire?current_id=124
# Pasos iniciales lando y git
## lando
Colocarnos en /home/enrique/laravel/lando

### Config 1 livewire nginx
- Instalar new project
```php
lando init \
  --source cwd \
  --recipe laravel \
  --webroot app/public \
  --name livewire
```

- Esto genera el archivo .lando.yml:
```php
name: livewire
recipe: laravel
config:
  webroot: app/public
```

- Con este archivo creado ya en laravel/lando/ podemos correr:
```php
lando ssh -c "composer global require laravel/installer && laravel new livewire --jet"
```
Vamos a usar jetstream con livewire

- Cambiarnos al directorio :
```php
cd livewire_victorArana
```

- Crear archivo configuración .lando.yml:
```php
name: livewire
recipe: laravel

config:
  php: '8.1'
  composer_version: 2-latest
  via: nginx
  webroot: public
  database: mysql:5.7
  cache: redis
  xdebug: false

services:
  node:
    type: node
   
tooling:
  npm:
    service: node
```

### Config 2 para livewire3 y apache
Crear proyecto
```php
lando init \
  --source cwd \
  --recipe laravel \
  --webroot app/public \
  --name livewire3
```
  
- lando ssh -c "composer global require laravel/installer && laravel new livewire3 --jet"

```php
name: livewire3
recipe: laravel

config:
  php: '8.0'
  composer_version: 2-latest
  via: apache
  webroot: public
  database: mysql:8.0
  cache: redis
  xdebug: false

services:
  node:
    type: node
   
tooling:
  npm:
    service: node
```  

### Paso 2 - Lando Start y DB Config
- Lando start
- lando info

- conectarnos a la base de datos con DBeaver
```php
Crear nueva conexión MySql:

- Server Host: localhost
- Port: 49156 (lando info)
- Database: laravel
- Username: laravel
- Password: laravel

Después renombrar la conexión en DBeaver a:
- livewire_victorArana
```

- configurar la base en .env
```php
APP_URL=http://livewire.lndo.site

DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

- migrar tablas:
```php
lando php artisan migrate
```
Listo!

### Paso 3 - Lando npm

- npm install:
```php
lando npm install
```

- npm run dev:
```php
lando npm run dev
```

En caso de no tener la carpeta de vendor, por si venimos de clonar de git
Regenerate vendor folder
```php
lando composer update
```
If the Composer is found corrupted, we uninstall the existing one and reinstall it. To install Composer, we run the command in the root project folder:
```php
composer install
```

### Paso 4 - Lando stop
Para apagar los contenedores
- lando stop
Por ultimo cambiarle el nombre a la carpeta de livewire a:
- livewire_nombre_deseado
Listo!

## Con xampp
Requisitos:
- xampp
- composer

Asegurarnos tener:
- composer global require laravel/installer
- php -v
PHP 7.4.3 (cli)

CD:
- cd /opt/lampp/htdocs
o
- cd /home/enrique/laravel/htdocs

Instalar proyecto:
- laravel new livewire --jet
- laravel new livewire2 --jet

Corre xampp Control Panel y Crear la base de datos 'livewire' en:
- http://localhost/phpmyadmin/

- cd livewire
Hacer la migración con:
- php artisan migrate

Correr el servidor:
- php artisan serve
Listo!
## git
- primero crear repositorio en github
- git init
- git remote add origin git@github.com:enriquesousa/livewire-lando.git
- git config remote.origin.url git@github.com:enriquesousa/livewire-lando.git
- git status
- git add -A
- git commit -m "livewire-lando commit inicial"
- git push origin master
 
- Listo!
# Sección 1: Introducción
## 01. Introducción a Livewire
Al crear el proyecto con --jet se incluye en resources/views/layouts/app.blade.php:
```php
<head>
  ...
  @livewireStyles
</head>
<body>
  ...
  @livewireScripts
</body>
```
tanto los livewire Styles como los Scripts.
Los scripts son lo que nos va a permitir darle reactividad a nuestro proyecto. Al colocar estas directivas aquí las podemos usar en todas las vistas que extiendan esta plantilla, como por ejemplo una de las vistas que extiende esta plantilla es resources/views/dashboard.blade.php.

Registrarnos:
```php
Name: Enrique
Email: enrique.sousa@gmail.com
Password: sousa1234
```

Eliminar:
```bash
<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <x-jet-welcome />
</div>
```
de resources/views/dashboard.blade.php.

Ya podemos trabajar en esta vista.
## 02. Cómo se renderizan los componentes de Livewire
Crear nuestro primer componente de livewire:
- lando php artisan make:livewire ShowPosts

Se crea app/Http/Livewire/ShowPosts.php donde el método mas importante es render():
```php
public function render()
{
    return view('livewire.show-posts');
}
```
Se encarga de renderizar la vista que se encuentra en 'livewire.show-posts', con esto, aseguramos la reactividad de nuestro proyecto, porque cada vez que se haga una petición al servidor se va a volver a renderizar el componente de livewire.

resources/views/livewire/show-posts.blade.php:
```php
<div>
  <h1>Hola mundo!</h1>
</div>
```
Todo tiene que quedar dentro de un <div> padre.

Para mandar llamar componente resources/views/dashboard.blade.php:
```php
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @livewire('show-posts')

    </div>
</div>
```

Para organizar los componentes dentro de carpetas, creamos el componente asi:
- lando php artisan make:livewire Nav/ShowPosts

Ya me crea el componente app/Http/Livewire/Nav/ShowPosts.php y la vista resources/views/livewire/nav/show-posts.blade.php.
Y para mandarla llamar usamos @livewire('nav.show-posts') en resources/views/dashboard.blade.php.

Para pasar parámetros al componente, lo hacemos atrevés de un array [atributo => valor]:
resources/views/dashboard.blade.php:
```php
@livewire('show-posts', ['title' => 'Este es un titulo de prueba'])
```
Para recibir la información, agregar una propiedad en app/Http/Livewire/ShowPosts.php:
```php
public $title;
public function render()
{
    return view('livewire.show-posts');
}
```
De esta manera cualquier propiedad que asignemos aqui, podra ser accedida por resources/views/livewire/show-posts.blade.php:
```php
<div>
  <h1>Hola mundo!</h1>
  {{ $title }}
</div>
```

Ahora, para poder recibir las propiedades en app/Http/Livewire/ShowPosts.php con otro nombre, por ejemplo $titulo en vez de $title, entonces tenemos que crear un nuevo método llamado mount():
```php
public $titulo;

public function mount($title){
    $this->titulo = $title;
}

public function render()
{
    return view('livewire.show-posts');
}
```
Y para desplegar la propiedad en la vista:
```php
<div>
  <h1>Hola mundo!</h1>
  {{ $titulo }}
</div>
```

Ahora queremos usar a los componentes como si fueran controladores, para asi poder incluirlos en nuestras vistas y tener su reactividad en todas nuestras paginas. Esto se hace asi, en web.php importamos a:
web.php:
```php
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShowPosts;
Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', ShowPosts::class)->name('dashboard');
```
15:00
Al utilizar livewire como un controlador ...
Podemos utilizar {{ $slot }} con nombres.
Creamos nuestra propia plantilla base.blade.php basada en app.blade.php para poder utilizarla y la modificamos.
resources/views/layouts/base.blade.php:
```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            
            <h1>Plantilla Base</h1>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
```
Para redirigir el componente a nuestra nueva plantilla en app/Http/Livewire/ShowPosts.php:
```php
public function render()
{
    return view('livewire.show-posts')
            ->layout('layouts.base');
}
```
Ahora si estamos extendiendo desde nuestra plantilla base.
Esto solo fue de prueba, eliminar la plantilla base!

Como podemos pasar parámetros por la url.
agregar ruta en, web.php:
```php
Route::get('prueba/{name}', ShowPosts::class);
```
En app/Http/Livewire/ShowPosts.php:
```php
<?php
namespace App\Http\Livewire;
use Livewire\Component;
class ShowPosts extends Component
{
    public $name;
    public function mount($name){
        $this->name = $name;
    }
    public function render()
    {
        return view('livewire.show-posts');
    }
}
```
en resources/views/livewire/show-posts.blade.php:
```php
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h1>Hola mundo!</h1>
    {{ $name }}
</div>
```
Al visitar:
- http://livewire.lndo.site/prueba/enrique
Ya tenemos empresa la variable nombre
Listo!
## 03. Vinculación de datos
Como recuperar información de la base de datos y pasarlo a la vista:
para esto primero hay que llenar de algunos datos la base de datos.
Crear el modelo Post con migraciones y factories.
- lando php artisan make:model Post -mf
En database/migrations/2022_02_13_172445_create_posts_table.php:
```php
Schema::create('posts', function (Blueprint $table) {
  $table->id();

  $table->string('title');
  $table->string('content');

  $table->timestamps();
});
```
En database/factories/PostFactory.php:
```php
public function definition()
{
  return [
      'title' => $this->faker->sentence(),
      'content' => $this->faker->text(),
  ];
}
```
En database/seeders/DatabaseSeeder.php:
```php
public function run()
{
  \App\Models\Post::factory(100)->create();
}
```
En app/Models/Post.php:
```php
protected $fillable = [
  'title',
  'content',
];
```
Por ultimo migrar fresh con seeders!
- lando php artisan migrate:fresh --seed
Listo!
Ahora para pasar los datos a la vista del componente.
En app/Http/Livewire/ShowPosts.php:
```php
<?php
namespace App\Http\Livewire;
use App\Models\Post;
use Livewire\Component;
class ShowPosts extends Component
{
  public function render()
  {
      $posts = Post::all();
      return view('livewire.show-posts', compact('posts'));
  }
}
```
Y en la vista resources/views/livewire/show-posts.blade.php:
```php
<div>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <h1>Hola mundo!</h1>
  {{ $posts }}
</div>
```
Listo!
Volver a registrarnos en nuestro proyecto y Listo!
Ya vemos en la vista todos los 100 registros raw!

Centrar el contenido de los datos recuperados de la base de datos.
usando las clases de Tailwind tal como las usan en la vista navigation-menu.blade.php, entonces:
en resources/views/livewire/show-posts.blade.php:
```php
<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{ $posts }}
  </div>
</div>
```
Listo!

Para bajar una tabla de tailwind, podemos buscar en google como tailwind ui components table y nos va a salir varias paginas, yo escogí esta tabla: 
https://tailwindcomponents.com/component/customers-table

Para formatear el código instalar la extension de vscode 'laravel blade formatter' y para usarla hacer click derecho en el documento que queremos format y escoger 'Format Document With ...' y escogemos Laravel Blade Formatter, también podemos acceder a esta opción con ctrl+shift+p y buscar Format Document ...

2:48
pasar los tres primeros div's antes de la tabla a un componente blade para que no nos haga ruido visual.
Para mover creamos:
resources/views/components/table.blade.php:
```php
<section class="container mx-auto p-6 font-mono">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
            
            {{ $slot }}

        </div>
    </div>
</section>
```
Y en resources/views/livewire/show-posts.blade.php:
```php
...
<!-- component -->
<x-table>
    <table class="w-full">
    ...
    </table>
</x-table>
```
Se manda llamar el $slot simplemente con <x-nombredelcomponente>


Para poder filtrar nuestra tabla y hacer búsqueda de registros ya sea por title o por content entonces en app/Http/Livewire/ShowPosts.php:
```php
<?php
namespace App\Http\Livewire;
use App\Models\Post;
use Livewire\Component;
class ShowPosts extends Component
{
    public $search;
    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->get();

        return view('livewire.show-posts', compact('posts'));
    }
}
```
Y en resources/views/livewire/show-posts.blade.php:
```php
<x-table>
  <div class="px-4 py-3">
      <input type="text" wire:model='search'>
  </div>
  ...
```

Para que se vea mas bonito el input box de la caja de search:
https://jetstream.laravel.com/2.x/installation.html
Application Logo:
After installing Jetstream, you may have noticed that the Jetstream logo is utilized on Jetstream's authentication pages as well as your application's top navigation bar. You may easily customize the logo by modifying a few Jetstream components.
Livewire:
If you are using the Livewire stack, you should first publish the Livewire stack's Blade components:
- lando php artisan vendor:publish --tag=jetstream-views

Con esto se generan muchos componentes de blade, el que nos interesa usar por el momento es:
resources/views/vendor/jetstream/components/input.blade.php
entonces en en resources/views/livewire/show-posts.blade.php:
```php
<div class="px-4 py-3">
    {{-- <input type="text" wire:model='search'> --}}
    <x-jet-input type="text" wire:model='search' />
</div>
```
Para acceder a los componentes que están dentro de la carpeta resources/views/vendor/jetstream/components/ usar:
- <x-jet-input  />

Por ultimo si hay algún post despliega la tabla, si no despliega un mensaje, entonces en resources/views/livewire/show-posts.blade.php:
```php
{{-- si hay algún post despliega la tabla --}}
...
@if ($posts->count())
    <table class="w-full">
      ...
    </table>
@else
    <div class="px-4 py-3">
        No existe ningún registro coincidente.
    </div>
@endif
```
Listo!
## 04. Acciones en Livewire
Ordenar por ID, title o content.
En app/Http/Livewire/ShowPosts.php:
```php
<?php
namespace App\Http\Livewire;
use App\Models\Post;
use Livewire\Component;
class ShowPosts extends Component
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';

    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->get();

        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort)
    {   
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

}
```

En resources/views/livewire/show-posts.blade.php:
```php
<div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- component -->
        <x-table>

            <div class="px-4 py-3">
                {{-- <input type="text" wire:model='search'> --}}
                <x-jet-input class="w-full" placeholder="Escriba que quiere buscar" type="text" wire:model='search' />
            </div>

            {{-- si hay algún post despliega la tabla --}}
            @if ($posts->count())
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                            <th class="cursor-pointer px-4 py-3" wire:click="order('id')">ID</th>
                            <th class="cursor-pointer px-4 py-3" wire:click="order('title')">
                                Titulo
                                <i class="fas fa-sort"></i>
                            </th>
                            <th class="cursor-pointer px-4 py-3" wire:click="order('content')">Contenido</th>
                            <th class="px-4 py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">

                        @foreach ($posts as $post)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border"> {{ $post->id }} </td>
                            <td class="px-4 py-3 text-ms border"> {{ $post->title }} </td>
                            <td class="px-4 py-3 text-ms border"> {{ $post->content }} </td>
                            <td class="px-4 py-3 text-sm border">Edit</td>
                        </tr>    
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="px-4 py-3">
                    No existe ningún registro coincidente.
                </div>
            @endif
            
        </x-table>
    </div>

</div>
```

Para adornarlo con fonts de fontawesome usar:
fontawesome-free 
yo tengo la version 4
https://fontawesome.com/versions

Copiar la carpeta que tengo de fontawesome-free que pesa como 3.3MB a: 
- public/vendor/fontawesome-free

Darlo de alta en resources/views/layouts/app.blade.php:
```php
<!-- Styles -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
```

14:12
Ya podemos usar sus iconos en resources/views/livewire/show-posts.blade.php con por ejemplo <i class="fas fa-sort"></i>, al aplicar este icono y acomodarlo al lado derecho que asi en resources/views/livewire/show-posts.blade.php:
```php
<div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- component -->
        <x-table>

            <div class="px-4 py-3">
                {{-- <input type="text" wire:model='search'> --}}
                <x-jet-input class="w-full" placeholder="Escriba que quiere buscar" type="text" wire:model='search' />
            </div>

            {{-- si hay algún post despliega la tabla --}}
            @if ($posts->count())
                <table>
                    <thead>
                        
                        <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                            <th scope="col" class="cursor-pointer px-4 py-3" wire:click="order('id')">
                                ID
                                {{-- sort --}}
                                @if ($sort == 'id')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </th>
                            <th class="cursor-pointer px-4 py-3" wire:click="order('title')">
                                Titulo
                                {{-- sort --}}
                                @if ($sort == 'title')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </th>
                            <th scope="col" class="cursor-pointer px-4 py-3" wire:click="order('content')">
                                Contenido
                                {{-- sort --}}
                                @if ($sort == 'content')
                                    @if ($direction == 'asc')
                                        <i class="fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif 
                            </th>
                            <th scope="col" class="px-4 py-3">Acción</th>
                        </tr>

                    </thead>
                    <tbody class="bg-white">

                        @foreach ($posts as $post)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border"> {{ $post->id }} </td>
                            <td class="px-4 py-3 text-ms border"> {{ $post->title }} </td>
                            <td class="px-4 py-3 text-ms border"> {{ $post->content }} </td>
                            <td class="px-4 py-3 text-sm border">Edit</td>
                        </tr>    
                        @endforeach

                    </tbody>
                </table>
            @else
                <div class="px-4 py-3">
                    No existe ningún registro coincidente.
                </div>
            @endif
            
        </x-table>
    </div>

</div>
```
Listo!
## 05. Métodos mágicos y modales
Crear botón para agregar registro:
- lando php artisan make:livewire create-post
Crea:
CLASS: app/Http/Livewire/CreatePost.php
VIEW:  resources/views/livewire/create-post.blade.php

Crear un modal, uno que ya esta hecho de jet.
resources/views/livewire/create-post.blade.php:
```php
<div>
    {{-- Do your work, then step back. --}}
    <x-jet-danger-button wire:click="$set('open', true)">
        Crear post
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model='open'>

        <x-slot name='title'>
            Crear nuevo post
        </x-slot>

        <x-slot name='content'>
            <div class="mb-4">
                <x-jet-label value="Título del Post"></x-jet-label>
                <x-jet-input type="text" class="w-full" wire:model.defer="title"></x-jet-input>
                {{ $title }}
            </div>
            <div class="mb-4">
                <x-jet-label value="Contenido del Post"></x-jet-label>
                <textarea wire:model.defer="content" class="form-control w-full" rows="6"></textarea>
                {{ $content }}
            </div>
        </x-slot>

        <x-slot name='footer'>
            <x-jet-secondary-button class="mr-2" wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="save">
                Crear Post
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>

</div>
```
Y en app/Http/Livewire/CreatePost.php:
```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
    public $open = \true;
    public $title, $content;

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save(){
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);
    }
}
```

11:42
Crear resources/css/form.css:
```php
.form-control{
    @apply border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm;
}
```
Copiamos los estilos del componente jet input.blade.php
Importar el archivo en resources/css/app.css:
```php
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

@import 'form.css';
```
Ahora compilar.
- lando npm run dev
Hicimos esto para poder usar el input de text area.
Ctrl-F5 en chrome or firefox para refrescar cache!

Para evitar que se comunique el wire:model de nuestro modal al backend cada vez que escribimos un character, usamos en vez de wire:model="title", usamos mejor:
- wire:model.defer="title"
## 06. Eventos y oyentes
Vamos a crear un evento 'renderiza' en app/Http/Livewire/CreatePost.php:
```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class CreatePost extends Component
{
    public $open = false;
    public $title, $content;

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save(){
        // Agregar registro a la tabla posts
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->reset(['open','title','content']);

        $this->emit('renderiza');
    }
}
```
Luego lo escuchamos en app/Http/Livewire/ShowPosts.php:
```php
<?php
namespace App\Http\Livewire;
use App\Models\Post;
use Livewire\Component;
class ShowPosts extends Component
{
    public $search;
    public $sort = 'id';
    public $direction = 'desc';

    //Cuando escuches el evento renderiza ejecuta el método render
    protected $listeners = ['renderiza' => 'render'];

    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->get();

        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort)
    {   
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

}
```
Listo!

Los eventos también los podemos escuchar en scripts, esto nos ayuda para trigger eventos de por ejemplo de sweetalert:
https://sweetalert2.github.io/

CDN:
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

Lo vamos a pegar en el head en la sección de scripts en resources/views/layouts/app.blade.php:
```php
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

y abajo crear el script, antes de que termine el body!
<script>
    livewire.on('alerta', function(mensaje){
        Swal.fire(
            'Good job!',
            mensaje,
            'success'
        )
    })
</script>
```

11:36
Para que solo un componente escuche el evento, en app/Http/Livewire/CreatePost.php:
```php
$this->emitTo('show-posts','renderiza');
$this->emit('alerta', 'El Post se creó satisfactoriamente');
```
Listo!
# Sección 2: Características de los componentes
## 07. Validaciones
- En app/Http/Livewire/CreatePost.php:
```php
 protected $rules = [
    'title' => 'required|max:100',
    'content' => 'required|max:150',
];
 public function save()
{
    $this->validate();

    ...
}
```
- En resources/views/livewire/create-post.blade.php:
```php
@error('title')
    <span>{{ $message }}</span>            
@enderror

y

@error('content')
    <span>{{ $message }}</span>            
@enderror
```
Una mejor manera para mostrar el mensaje de error es usar un componente jet asi:
```php
<x-jet-input-error for='title' />

```

Validación en tiempo real
cada vez que se da una letra checa si cumple con las reglas de validación, entonces en app/Http/Livewire/CreatePost.php:
```php
 // se ejecuta cada vez que cambia una de las propiedades title or content
public function updated($propertyName)
{
    // cada vez que se da una letra checa si cumple con las reglas de validación
    $this->validateOnly($propertyName);
}
```
Y tenemos que quitar el defer en resources/views/livewire/create-post.blade.php:
```php
<div class="mb-4">
    <x-jet-label value="Título del Post"></x-jet-label>
    <x-jet-input type="text" class="w-full" wire:model="title"></x-jet-input>
    <x-jet-input-error for='title' />
</div>
```
Listo!
## 08. Estados de carga
Hay varias maneras de avisar al usuario de lso estados de carga.
en resources/views/livewire/create-post.blade.php:
```php
<x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target='save' class="disabled:opacity-25">
    Crear Post
</x-jet-danger-button>

{{-- solo mostrar span cuando se esta ejecutando el método save --}}
{{-- <span wire:loading wire:target='save'>Cargando ...</span> --}}
```
En app/Http/Livewire/CreatePost.php:
```php
public function save()
{
    sleep(1);
    $this->validate();

    // Agregar registro a la tabla posts
    Post::create([
        'title' => $this->title,
        'content' => $this->content,
    ]);

    $this->reset(['open','title','content']);

    $this->emitTo('show-posts','renderiza');
    $this->emit('alerta', 'El Post se creó satisfactoriamente');
}


// se ejecuta cada vez que cambia una de las propiedades title or content
// public function updated($propertyName)
// {
//     // cada vez que se da una letra checa si cumple con las reglas de validación
//     $this->validateOnly($propertyName);
// }
```
Listo!
## 09. Subir imágenes
Agregar campo 'image' a la migración en database/migrations/2022_02_13_172445_create_posts_table.php:
```php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();

        $table->string('title');
        $table->string('content');
        $table->string('image');

        $table->timestamps();
    });
}
```

Cambiar el path de acceso de local a public en config/filesystems.php:
```php
'default' => env('FILESYSTEM_DRIVER', 'public'),
```

Crear imágenes falsas en database/factories/PostFactory.php:
```php
class PostFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'image' => 'posts-images/' . $this->faker->image('public/storage/posts-images', 640, 480, null, false), // con false me regresa solo: imagen.jpg
        ];
    }
}
``` 
Crear la carpeta posts/ en database/seeders/DatabaseSeeder.php:
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Storage::deleteDirectory('public/posts-images');
        Storage::makeDirectory('public/posts-images');
        
        \App\Models\Post::factory(100)->create();
    }
}
```
Ahora 
Storage Link con lando!
```php
lando php artisan storage:link
```
Ahora Ejecutar los Seeders:
- lando php artisan migrate:fresh --seed

Listo! ya funciono!
Volver a registrarnos en el sistema.

Para poder subir y ver imágenes en el componente de livewire en app/Http/Livewire/CreatePost.php:
```php
use Livewire\WithFileUploads;
class CreatePost extends Component
{
    use WithFileUploads;
    ...
}
```

Alertas de tailwind
https://v1.tailwindcss.com/components/alerts
```php
{{-- tailwind alert --}}
<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">Holy smokes!</strong>
    <span class="block sm:inline">Something seriously bad happened.</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20">
            <title>Close</title>
            <path
                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
        </svg>
    </span>
</div>
```
Agregar el alert en resources/views/livewire/create-post.blade.php:
```php
 <x-slot name='content'>

    {{-- tailwind alert --}}
    <div wire:loading wire:target='image' class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Cargando imagen!</strong><span class="block sm:inline">Espere un momento hasta que la imagen se haya procesado.</span>
    </div>

    @if ($image)
        <img class="mb-4" src="{{ $image->temporaryUrl() }}">
        {{ sleep(1) }}
    @endif

    ...
```
Tambien deshabilidar boton de crear post cuando se este cargando una imagen, en resources/views/livewire/create-post.blade.php:
```php
<x-slot name='footer'>
    <x-jet-secondary-button class="mr-2" wire:click="$set('open', false)">
        Cancelar
    </x-jet-secondary-button>

    <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target='save, image'
        class="disabled:opacity-25">
        Crear Post
    </x-jet-danger-button>
</x-slot>
```
Listo!
Ahora para salvar la imagen en app/Http/Livewire/CreatePost.php:
```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open = true;
    public $title, $content, $image, $identificador;

    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'image' => 'required|image|max:2048', //image max 2Mb
    ];

    public function render(){
        return view('livewire.create-post');
    }

    public function mount(){
        $this->identificador = rand(); //init con numero al azar
    }

    public function save(){
        sleep(1);
        $this->validate();

        // guardar la imagen en carpeta public/posts
        // $image_url = $this->image->store('posts');
        $image_url = $this->image->store('public/posts-images');


        // Agregar registro a la tabla posts
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image_url,
        ]);

        $this->reset(['open','title','content','image']);
        $this->identificador = rand(); //init con numero al azar

        $this->emitTo('show-posts','renderiza');
        $this->emit('alerta', 'El Post se creó satisfactoriamente');
    }


    // se ejecuta cada vez que cambia una de las propiedades title or content
    // public function updated($propertyName)
    // {
    //     // cada vez que se da una letra checa si cumple con las reglas de validación
    //     $this->validateOnly($propertyName);
    // }

}
```
En app/Models/Post.php:
```php
protected $fillable = [
    'title',
    'content',
    'image',
];
```
En resources/views/livewire/create-post.blade.php:
```php
<div>
    {{-- Do your work, then step back. --}}
    <x-jet-danger-button wire:click="$set('open', true)">
        Crear post
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model='open'>

        <x-slot name='title'>
            Crear nuevo post
        </x-slot>

        <x-slot name='content'>

            {{-- tailwind alert, para avisar al user que se esta subiendo una imagen --}}
            <div wire:loading wire:target='image' class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Cargando imagen!</strong>
                <span class="sm:inline">Espere un momento ...</span>
                {{-- con block lo baja una linea --}}
                {{-- <span class="block sm:inline">Espere un momento, en lo que procesa ...</span>  --}}
            </div>

            {{-- Cada vez que se selecciona una imagen en el input de input type="file", se almacena una imagen temporal en temporaryUrl() que se encuentra real en path /storage/app/livewire-tmp  --}}
            @if ($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}">
                {{-- use sleep(1) un segundo para simular tiempo de espera de internet --}}
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
                <textarea wire:model.defer="content" class="form-control w-full" rows="6"></textarea>
                <x-jet-input-error for='content' />
            </div>


            {{-- imagen del post --}}
            <div>
                <input type="file" wire:model='image' id="{{ $identificador }}">
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

</div>
```
Listo!

20:22
usar $identificador para que haga reset a la variable file del input de la imagen y asi ya no ver el ultimo nombre de archivo que subimos.
Listo!
## 10. Componentes de anidamiento EditPost
Crear componente livewire
- lando php artisan make:livewire EditPost
CLASS: app/Http/Livewire/EditPost.php
VIEW:  resources/views/livewire/edit-post.blade.php

5:55
Para asignarle los estilos de un botón: 
Crear resources/css/buttons.css:
```php
.btn{
    @apply font-bold text-white py-2 px-4 rounded cursor-pointer;
}

.btn-red{
    @apply bg-red-600 hover:bg-red-500;
}

.btn-blue{
    @apply bg-blue-600 hover:bg-blue-500;
}

.btn-green{
    @apply bg-green-600 hover:bg-green-500;
}
```
Importar en resources/css/app.css:
```php
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

@import 'form.css';
@import 'buttons.css';
```

Compilar:
- lando npm run dev
Dejar corriendo con:
- lando npm run watch

9:11
resources/views/livewire/edit-post.blade.php:
```php
<div>

    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fas fa-edit"></i>
    </a>

    <x-jet-dialog-modal wire:model="open">

        <x-slot name='title'>
            Editar el post {{ $post->title }}
        </x-slot>

        <x-slot name='content'>
        </x-slot>

        <x-slot name='footer'>
        </x-slot>

    </x-jet-dialog-modal>

</div>
```
Listo!
Queremos que cuando haga click en el botón, se abra el modal de:
- <x-jet-dialog-modal>

En resources/views/livewire/edit-post.blade.php:
```php
<div>

    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fas fa-edit"></i>
    </a>

    <x-jet-dialog-modal wire:model="open">

        <x-slot name='title'>
            {{-- Editar el post - {{ $post->title }} --}}
            Editar el post
        </x-slot>

        <x-slot name='content'>
            <div class="mb-4">
                <x-jet-label value="Título del post" />
                <x-jet-input wire:model="post.title" type="text" class="w-full" />
            </div>
            <div>
                <x-jet-label value="Contenido del post" />
                <textarea wire:model="post.content" rows="6" class="form-control w-full"></textarea>
            </div>
        </x-slot>

        <x-slot name='footer'>
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="save" wire:loading.attr='disabled' class="ml-2 disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>

</div>
```
En app/Http/Livewire/EditPost.php:
```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class EditPost extends Component
{
    public $open = false;
    public $post;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function mount(Post $post){
        $this->post = $post;
    }

    public function save(){
        $this->validate();
        $this->post->save();
        $this->reset(['open']);
        $this->emitTo('show-posts','renderiza');
        $this->emit('alerta', 'El Post se actualizó satisfactoriamente');
    }

    public function render(){
        return view('livewire.edit-post');
    }
}
```
Listo!

21:32
Ahora agregar un selector de archivos para seleccionar una imagen también igual que lo hicimos en crear post!

En resources/views/livewire/edit-post.blade.php:
```php
<div>

    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fas fa-edit"></i>
    </a>

    <x-jet-dialog-modal wire:model="open">

        <x-slot name='title'>
            {{-- Editar el post - {{ $post->title }} --}}
            Editar el post
        </x-slot>

        <x-slot name='content'>

            {{-- tailwind alert --}}
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
                <input type="file" wire:model='image' id="{{ $identificador }}">
                <x-jet-input-error for='image' />
            </div>

        </x-slot>

        <x-slot name='footer'>
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button wire:click="save" wire:loading.attr='disabled' class="ml-2 disabled:opacity-25">
                Actualizar
            </x-jet-danger-button>
        </x-slot>

    </x-jet-dialog-modal>

</div>
```

En app/Http/Livewire/EditPost.php:
```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use WithFileUploads;

    public $open = false;
    public $post, $image, $identificador;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function mount(Post $post){
        $this->post = $post;
        $this->identificador = rand(); //init con numero al azar
    }

    public function save(){
        $this->validate();

        //check si escogieron una imagen, eliminamos imagen almacenada
        if ($this->image) {
            // eliminamos imagen almacenada
            Storage::delete([$this->post->image]);
            // subir nueva imagen
            // $this->post->image = $this->image->store('public/posts');
            $this->post->image = $this->image->store('public/posts-images');
        }

        $this->post->save();
        $this->reset(['open', 'image']);
        $this->identificador = rand();
        $this->emitTo('show-posts','renderiza');
        $this->emit('alerta', 'El Post se actualizó satisfactoriamente');
    }

    public function render(){
        return view('livewire.edit-post');
    }
}
```
Listo!
Ya me funciono todo hasta aquí!
## 11. Pasar parámetros de acción
Ya vamos a usar el componente de anidamiento {{-- @livewire('edit-post', ['post' => $post], key($post->id)) --}} en resources/views/livewire/show-posts.blade.php porque esto hace mas lento la aplicación, lo mejor seria usar un solo modal para toda la pagina de show-posts y en vez de componentes anidados que crean una modal cada vez que se manda llamar, mejor usamos botones que nos van a mandar llamar a la única ventana modal de la vista.

En app/Http/Livewire/ShowPosts.php:
```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ShowPosts extends Component
{
    public $search, $post, $image, $idinputimagen;
    public $sort = 'id';
    public $direction = 'desc';

    public $open_edit = false;

    public function mount(){
        $this->idinputimagen = rand();
        // esto es para que la variable $image se convierta ya en un objeto
        // el cual la estaremos usando en el modal de resources/views/livewire/show-posts.blade.php
        $this->post = new Post();
    }

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    // Cuando escuches el evento render ejecuta el método render
    // protected $listeners = ['render' => 'render'];
    // Cuando el nombre de listener es igual al del método podemos omitir uno asi:
    protected $listeners = ['render'];

    public function render()
    {
        // $posts = Post::all();
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->get();
        
        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort)
    {   
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Post $post){
        $this->post = $post;
        $this->open_edit = true;
    }

    public function update(){
        $this->validate();

        //check si escogieron una imagen, eliminamos imagen almacenada
        if ($this->image) {
            // eliminamos imagen almacenada
            Storage::delete([$this->post->image]);
            // subir nueva imagen
            $this->post->image = $this->image->store('public/posts-images');
        }

        $this->post->save();
        $this->reset(['open_edit', 'image']);
        $this->idinputimagen = rand();
        $this->emit('alerta', 'El Post se actualizó satisfactoriamente');
    }
    
}
```

En resources/views/livewire/show-posts.blade.php:
```php
<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <x-table>

            <div class="px-6 py-4 flex items-center">
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
                                        {{ $item->content }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{-- @livewire('edit-post', ['post' => $post], key($post->id)) --}}
                                    <a class="btn btn-green" wire:click="edit({{ $item }})">
                                        <i class="fas fa-edit"></i>
                                    </a>
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

</div>
``` 
Listo!
Ya funciono todo hasta aquí.
## 12. Paginación
Se nos olvido la clase pasada usar use WithFileUploads; en app/Http/Livewire/ShowPosts.php para poder subir imágenes!
Ahora vamos a usar el método paginate() en render() en ShowPosts:
```php
$posts = Post::where('title', 'like', '%' . $this->search . '%')
        ->orWhere('content', 'like', '%' . $this->search . '%')
        ->orderBy($this->sort, $this->direction)
        ->paginate(5);
```
Y Para colocar los enlaces de Paginación en resources/views/livewire/show-posts.blade.php:
```php
<div class="px-6 py-3">
    {{ $posts->links() }}
</div>
```

6:18
En la siguiente clase vamos a resolver el problema de que si nos colocamos en la ultima pagina y hacemos una búsqueda de un registro nos va a decir que el registro no existe.
## 13. Ciclos de vida - updatingSearch()
Hasta ahorita hemos visto solo el ciclo de vida de mount(), pero para resolver el problema en que nos quedamos en la clase pasada, ahora vamos a conocer otros tipos de componentes que nos ofrece livewire:

Lifecycle Hooks
https://laravel-livewire.com/docs/2.x/lifecycle-hooks

El que nos puede ayudar es:
- updatingFoo()

Entonces en app/Http/Livewire/ShowPosts.php:
```php
public function updatingSearch(){
    // Este método se va a ejecutar cada vez que se haga un cambio a la propiedad $search
    // Y resetPage() nos ayuda a quitar la paginación del componente para poder encontrar el registro 
    $this->resetPage();
}
```
Listo!
Ya funciono.
## 14. Query String - datos por la url
En app/Http/Livewire/ShowPosts.php:
```php
    use WithFileUploads;
    use WithPagination;

    public $post, $image, $idinputimagen;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '10';

    public $open_edit = false;

    public $queryString = [
        // poner el parámetro que queremos que viaje por la url
        // Y usamos except p/no mostrar cuando los parámetros son los predeterminados
        'cant' => ['except' => '10'], 
        'sort' => ['except' => 'id'], 
        'direction' => ['except' => 'desc'], 
        'search' => ['except' => '']
    ];
```
Listo!
Ya funciono todo hasta aquí.
# Sección 3: Detalles de la interfaz de usuario
## 15. Aplazar Carga - Tiempo de Carga de la Tabla
Los cambios en app/Http/Livewire/ShowPosts.php:
```php
...
public $readyToLoad = false;
public function render(){
        
    if ($this->readyToLoad) {
        $posts = Post::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);    
    }else{
        $posts = [];
    }

    return view('livewire.show-posts', compact('posts'));
}
...
public function loadPosts(){
    // para indicar a la vista show-posts que ya se cargaron todos los elementos
    sleep(1); // para simular el tiempo de carga de una pagina grande! con imágenes.
    $this->readyToLoad = true;
}
```

Y los cambios en resources/views/livewire/show-posts.blade.php:
```php
En el main div agregar el método wire:init='loadPosts':
<div wire:init='loadPosts'>

    En el if de la iteración de los registros modificar la forma en que pasamos la propiedad $posts, y mover los hasPages() dentro del if:
    @if (count($posts))
        <table class="table-auto w-full">
        </table>

        @if ($posts->hasPages())
            <div class="px-6 py-3">
                {{ $posts->links() }}
            </div>    
        @endif
    @else
        <div class="px-4 py-3">
            No existe ningún registro coincidente.
            <i class="fas fa-spinner"></i>
        </div>
    @endif

</div>
```
Listo!
Ya funciono hasta aquí.
# Sección 4: Integraciones JS
## 16. Como integrar CKEditor 5 con Livewire
CKEditor 5 download
https://ckeditor.com/ckeditor-5/download/

CDN
```php
<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
```

Colocar dos @stack en resources/views/layouts/app.blade.php:
```php
<head>
    ...
    @livewireStyles
    @stack('css')
    ...
</head>
<body class="font-sans antialiased">
    ...
    @livewireScripts
    @stack('js')
    ...
</body>
```

Y en resources/views/livewire/create-post.blade.php:
```php
<div wire:init='loadPosts'>
...
    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>

        {{-- inicializar pulgin https://ckeditor.com/docs/ckeditor5/latest/builds/guides/quick-start.html --}}
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>

    @endpush
</div>
``` 
Todo lo que coloquemos dentro de la directiva @push('js') se coloca en @stack('js') de app.blade.php.

Usar wire:ignore en el div de textarea para indicar a livewire que no renderize el componente para seguir conservando el estilo del plugin.
Para poder lograr cambiar la propiedad de content tenemos que modificar el js del plugin ckeditor, ya que al momento de user wire:ignore en el textarea perdimos la posibilidad de sincronizar la propiedad content, por esa razón modificaremos el js del puling asi:
en resources/views/livewire/create-post.blade.php:
```php
...
{{-- Contenido del post --}}
<div class="mb-4" wire:ignore>
    <x-jet-label value="Contenido del Post"></x-jet-label>
    <textarea id="editor" 
            wire:model.defer="content" 
            class="form-control w-full" 
            rows="6">

    </textarea>
    <x-jet-input-error for='content' />
</div>
...
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then(function(editor){
            editor.model.document.on('change:data', () => {
                @this.set('content', editor.getData());    
            })
        })
        .catch( error => {
            console.error( error );
        } );
</script>
...
```
Listo!
Ya me funciono todo hasta aquí.

Displaying HTML with Blade shows the HTML code
https://stackoverflow.com/questions/29253979/displaying-html-with-blade-shows-the-html-code

para solucionar este problema usar mejor {!! $item->content !!}  en resources/views/livewire/show-posts.blade.php:
```php
<div class="text-sm text-gray-900">
    {{-- {{ $item->content }} --}}
    {!! $item->content !!}
</div>
```
Listo!
## 17. Como integrar Sweet Alert 2 con Livewire - botón eliminar un registro
Agregar el botón para poder eliminar un registro.

Sweetalert2
https://sweetalert2.github.io/#examples
CDN
```php
<script src="sweetalert2.all.min.js"></script>
```
Incluirla en nuestro proyecto en resources/views/livewire/show-posts.blade.php:
```php
...
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
...
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
```

Y en app/Http/Livewire/ShowPosts.php:
```php
...
protected $listeners = ['render', 'delete'];
...
public function delete(Post $post){
    $post->delete();
}
```
Listo!
Ya funciono todo hasta aquí.
## 18. Comunicación entre Livewire y Alpine
Crear un nuevo proyecto en htdocs
- laravel new alpine --jet
Correr el xampp para prender los servicios
Crear la base de datos en phpmyadmin
Correr las migraciones:
- php artisan migrate
Instalar las librerias:
- npm install
Compilar para generar el public/js/app.js que vamos a utilizar:
- npm run dev
Y si vemos que en resources/views/layouts/app.blade.php esta ya cargando a:
```php
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
```

Crear nuevo componente de livewire:
- php artisan make:livewire Alpine
## 19. Limpiar datos del modal


