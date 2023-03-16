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

class CreateService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(ServiceObject $service)
    {
        $data = $service->toArray();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //all validation is done at this point, fire in the hole!
        try {
            $service = new Service($this->data);
            $service->save();
        } catch (\Exception $e) {
            Log::critical("Could not create service object from these params: " . print_r($this->data));
        }



    }
}
