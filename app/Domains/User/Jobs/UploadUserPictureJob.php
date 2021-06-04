<?php

namespace App\Domains\User\Jobs;

use App\Models\User;
use App\Traits\Uploads;
use Lucid\Units\Job;

class UploadUserPictureJob extends Job
{
//    use Uploads;

    private User $user;
    private $pickerFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $pickerFile)
    {
        $this->user = $user;
        $this->pickerFile = $pickerFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $media = $this->getMedia($this->pickerFile, 'users');
//        $this->user->attachMedia($media, 'picture');
    }
}
