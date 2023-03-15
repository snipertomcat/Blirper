<?php

namespace App\Jobs;

use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $service;

    private string $deviceType;

    private string $address;

    private string $token;

    /**
     * Create a new job instance.
     */
    public function __construct(array $params)
    {
        foreach ($params as $key=>$val) {
            if (isset($this->$key)) {
                $this->$key = $val;
            }
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->prune();

        Token::create([
            'service' => $this->service,
            'device_type' => $this->deviceType,
            'token' => $this->token
        ]);
    }

    private function prune()
    {
        Token::where('service', $this->service)->delete();
    }
}
