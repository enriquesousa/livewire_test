<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;

    public $open = false;
    public $post, $image, $idinputimagen;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function mount(Post $post){
        $this->post = $post;
        $this->idinputimagen = rand();
    }

    public function save(){
        $this->validate();

        //check si escogieron una imagen, eliminamos imagen almacenada
        if ($this->image) {
            // eliminamos imagen almacenada
            Storage::delete([$this->post->image]);
            // subir nueva imagen
            $this->post->image = $this->image->store('public/posts-images');
        }

        $this->post->save();
        $this->reset(['open', 'image']);
        $this->idinputimagen = rand();
        $this->emitTo('show-posts','render');
        $this->emit('alerta', 'El Post se actualizó satisfactoriamente');
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
