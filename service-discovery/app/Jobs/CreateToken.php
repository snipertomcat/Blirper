<?php

namespace App\Jobs;

use App\DataObjects\DataObjectContract;
use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;

class CreateToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     */
    #[Pure] public function __construct(DataObjectContract $token)
    {
        $this->data = $token->toArray();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            try {
                $token = Token::firstOrNew(['service_id' => $this->data['serviceId']]);
                $token->fill($this->data);
                $token->save();
            } catch (\Exception $e) {
                $logData = json_encode([
                    'status' => $e->getCode(),
                    'error' => $e->getMessage(),
                    'data' => $this->data
                ], JSON_THROW_ON_ERROR);
                Log::critical($logData);
                throw new \Exception("Service could not be registered");
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        dd($this);
    }
}
