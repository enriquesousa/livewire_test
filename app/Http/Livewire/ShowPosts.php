<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $post, $image, $idinputimagen;
    public $search = '';
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '10';
    public $readyToLoad = false;

    public $open_edit = false;

    protected $listeners = ['render', 'delete'];

    public $queryString = [
        // poner el parámetro que queremos que viaje por la url
        // Y usamos except p/no mostrar cuando los parámetros son los predeterminados
        'cant' => ['except' => '10'], 
        'sort' => ['except' => 'id'], 
        'direction' => ['except' => 'desc'], 
        'search' => ['except' => '']
    ];
    
    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function mount(){
        $this->idinputimagen = rand();
        /* esto es para que la variable $image se convierta ya en un objeto
        el cual la estaremos usando en el modal de resources/views/livewire/show-posts.blade.php */
        $this->post = new Post();
    }

    public function updatingSearch(){
        // Este método se va a ejecutar cada vez que se haga un cambio a la propiedad $search
        // Y resetPage() nos ayuda a quitar la paginación del componente para poder encontrar el registro 
        $this->resetPage();
    }

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

    public function order($sort){   
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

    public function loadPosts(){
        // para indicar a la vista show-posts que ya se cargaron todos los elementos
        sleep(1); // para simular el tiempo de carga de una pagina grande! con imágenes.
        $this->readyToLoad = true;
    }

    public function delete(Post $post){
        $post->delete();
    }

}
