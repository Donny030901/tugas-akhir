<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProfilJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->data['id']);

        $user->update([
            'id' => $this->data['id'],
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => $this->data['password'],
            'created_at' => $this->data['created_at'],
            'updated_at' => $this->data['updated_at'],
            'foto' => $this->data['foto'],
            'level' => $this->data['level'],
        ]);
    }
}
