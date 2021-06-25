<?php
    
    namespace App\Domains\User\Jobs;
    
    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;
    use Lucid\Units\Job;
    
    class CreateUserClientTokenJob extends Job
    {
        private User $user;
        private  string $token;
        private  $expiresIn;
        private  $name;
        private  $email;
        private  $id;
        private  $avatar;
        private  $nickname;
        
        /**
         * Create a new job instance.
         *
         * @return void
         */
        public function __construct(User $user, $token, $expiresIn = '', $name='', $email='', $id='', $avatar='', $nickname='')
        {
            $this->user=$user;
            $this->token=$token;
            $this->expiresIn=$expiresIn;
            $this->name=$name;
            $this->email=$email;
            $this->id=$id;
            $this->avatar=$avatar;
            $this->nickname=$nickname;
        }
        
        /**
         * Execute the job.
         *
         * @return Model
         */
        public function handle(): Model
        {
            $this->user->userClientToken()->update(['is_active'=>false]);
            return $this->user->userClientToken()->create([ 'token'=>$this->token, 'expires_in'=>$this->expiresIn, 'name'=>$this->name, 'email'=>$this->email, 'client_id'=>$this->id, 'avatar'=>$this->avatar, 'nickname'=>$this->nickname,]);
        }
    }
