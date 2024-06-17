<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'create:admin 
                            {nombreUsuario : El nombre de usuario del admin}
                            {email : El email del admin}
                            {telefono : El telefono del admin}
                            {password : La contraseña del admin}';
    
    protected $description = 'Crear un usuario administrador';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $nombreUsuario = $this->argument('nombreUsuario');
        $email = $this->argument('email');
        $telefono = $this->argument('telefono');
        $password = $this->argument('password');

        $usuario = Usuario::create([
            'nombreUsuario' => $nombreUsuario,
            'email' => $email,
            'telefono' => $telefono,
            'password' => Hash::make($password),
        ]);

        Admin::create([
            'usuario_id' => $usuario->id,
        ]);

        $this->info('Usuario administrador creado correctamente');
    }
}
