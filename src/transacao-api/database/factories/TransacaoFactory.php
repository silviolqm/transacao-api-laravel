<?php

namespace Database\Factories;

use App\Models\Transacao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransacaoFactory extends Factory
{
    protected $model = Transacao::class;

    public function definition(): array
    {
        return [
            'valor' => $this->faker->randomFloat(2, 10, 100000),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'documento_path' => 'documentos/comprovante_' . Str::random(8) . '.pdf',
            'status' => $this->faker->randomElement(['Em processamento', 'Aprovada', 'Negada']),

            'user_id' => User::factory(),
        ];
    }
}
