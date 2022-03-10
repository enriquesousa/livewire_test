<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open = false;
    public $title, $content, $image, $idinputimagen;

    protected $rules = [
        'title' => 'required',
        'content' => 'required',
        'image' => 'required|image|max:2048', //image max 2Mb
    ];

    public function mount(){
        $this->idinputimagen = rand();
    }

    public function render(){
        return view('livewire.create-post');
    }

    /* // se ejecuta cada vez que cambia una de las propiedades title or content
    public function updated($propertyName){
        // cada vez que se da una letra checa si cumple con las reglas de validación
        $this->validateOnly($propertyName);
    } */

    public function save(){
        
        $this->validate();

        sleep(1); // simular tiempo de carga internet
        
        // guardar la imagen en carpeta public/posts-images
        $image_url = $this->image->store('public/posts-images');

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image_url,
        ]);

        // Para que limpie variables y apague ventana modal
        $this->reset(['open','title','content','image']);
        $this->idinputimagen = rand(); //init con numero al azar

        $this->emitTo('show-posts','render');
        $this->emit('alerta', 'El Post se creó satisfactoriamente');
        
    }

   public function updatingOpen(){
       //se ejecuta justo antes de que se abre el modal
       if ($this->open == false) {
           $this->reset(['content', 'title', 'image']);
           $this->idinputimagen = rand();
           $this->emit('resetCKEditor');
       }
       
   } 

}
