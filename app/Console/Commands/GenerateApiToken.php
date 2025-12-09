<?php

namespace App\Console\Commands;

use App\Models\Usuario;
use Illuminate\Console\Command;

class GenerateApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:generate-token {email} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a long-lived API token for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->argument('name');

        $user = Usuario::where('USUARIO', $email)->first();

        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado.");
            return 1;
        }

        $token = $user->createToken($name)->plainTextToken;

        $this->info("Token generado exitosamente para {$email}:");
        $this->line($token);

        return 0;
    }
}
