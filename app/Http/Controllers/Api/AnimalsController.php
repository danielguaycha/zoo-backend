<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Animal;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnimalsController extends ApiController
{
    use UploadTrait;

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    public function index(Request $request)
    {
        $page = 1;
        $limit = 2;
        $search = '';

        // page
        if ($request->query('page'))
            $page = $request->query('page');

        // limit
        if($request->query('limit')) {
            $limit = $request->query('limit');
        }

        // search
        if ($request->query('search')) {
            $search = $request->query('search');
        }

        $offset = (intval($page)-1) * intval($limit);

        $a = Animal::where('name', 'like', "$search%")
            ->orderBy('id', 'desc')->limit($limit)->offset($offset)->get();

        return $this->custom([
            'ok' => true,
            'data' => $a,
            'total' => Animal::count()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'science_name' => 'nullable|string|max:50',
            'description' => 'required|string|max:200',
            'img' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $animal = new Animal();
        $animal->name = Str::upper($request->get('name'));
        $animal->science_name = $request->get('science_name');
        $animal->description = $request->get('description');
        $animal->img = $this->uploadOne($request->file('img'), '/animals', 'public');

        $animal->save();

        return $this->showOne($animal);
    }

    public function show($id)
    {
        $a = Animal::findOrFail($id);

        return $this->showOne($a);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'science_name' => 'nullable|string|max:50',
            'description' => 'required|string|max:200',
        ]);

        $animal = Animal::FindOrFail($id)->update([
            'name' => Str::upper($request->get('name')),
            'science_name' => $request->get('science_name'),
            'description' => $request->get('description')
        ]);

        if ($animal)
            return $this->ok('Datos actualizados con éxito');

        return $this->err('No se ha podido actualizar los datos');
    }

    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);

        if ($animal->delete()) {
            return $this->ok("Eliminado correctamente");
        }

        return $this->err("No se ha podido eliminar");
    }

    public function updateImg(Request $request, $id) {
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg'
        ]);
        $animal = Animal::findOrFail($id);
        $animal->img = $this->uploadOne($request->file('img'), '/animals', 'public');

        if ($animal->save()) {
            return $this->ok('Imagen cambiada con éxito');
        }

        return $this->err('No se ha podido cambiar la imagen');
    }
}
