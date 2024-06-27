<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'email_verified_at' => Carbon::now(),
        ]);

        if ($usuario->email_verified_at) {
            $this->info('Campo email_verified_at establecido correctamente');
        } else {
            $this->error('El campo email_verified_at no se ha establecido');
        }

        Admin::create([
            'usuario_id' => $usuario->id,
        ]);

        $this->info('Usuario administrador creado correctamente');
    }
}
