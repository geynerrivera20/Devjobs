<?php

namespace App\Http\Livewire;

use App\Models\Vacante;
use Livewire\Component;

class HomeVacantes extends Component
{
    public $termino;
    public $categoria;
    public $salario;

    protected $listeners = ['terminosBusqueda'=>'buscar'];

    public function buscar($termino,$categoria,$salario)
    {
         $this->termino = $termino;
         $this->categoria = $categoria;
         $this->salario = $salario;
    }

    public function render()
    {

        //$vacantes = Vacante::all();

        //Este solamente se ejecuta cuando le envien un termino.
        $vacantes = Vacante::when($this->termino,function($query){
            //Consulta por termino, no importa si esta al inicio o al final (%)
            $query->where('titulo','LIKE',"%".$this->termino."%");
        })->when($this->termino,function($query){
            //Consulta por termino, no importa si esta al inicio o al final (%)
            $query->orWhere('empresa','LIKE',"%".$this->termino."%");
        })->when($this->categoria,function($query){
            //Consulta por termino, no importa si esta al inicio o al final (%)
            $query->where('categoria_id',$this->categoria);
        })->when($this->salario,function($query){
            //Consulta por termino, no importa si esta al inicio o al final (%)
            $query->where('salario_id',$this->salario);
        })
        ->paginate(20);

        return view('livewire.home-vacantes',[
            'vacantes'=> $vacantes,
        ]);
    }
}
