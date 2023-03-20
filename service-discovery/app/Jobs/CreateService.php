<?php

namespace App\Jobs;

use App\DataObjects\DataObjectContract;
use App\DataObjects\ServiceObject;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;

class CreateService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     */
    #[Pure] public function __construct(DataObjectContract $service)
    {
        $this->data = $service->toArray();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            try {
                // We only want one copy of each service registered in the system, so i used firstOrNew
                // As a side note, i could have opted for a database constraint in the form of a unique index
                $service = Service::firstOrNew(['name' => $this->data['name']]);
                $service->fill($this->data);
                $service->save();
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
    }
}
