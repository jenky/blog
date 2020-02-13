<?php

namespace App\Console\Commands;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user
                            {--A|admin : Create new user as Administrator}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->name();
        $email = $this->email();
        $password = bcrypt($this->password());
        $type = $this->option('admin') ? 'admin' : $this->type();

        $confirm = $this->confirm(
            sprintf('Create new user: %s - %s | %s', $name, $email, $type)
        );

        if ($confirm) {
            $type = $type == 'user' ? null : $type;
            if ($user = User::create(compact('name', 'email', 'password', 'type'))) {
                $this->info('Successfully create user: '.$user->name);
            } else {
                $this->error('Unable to create new user. Please try again.');
            }
        } else {
            $this->comment('Aborted!');
        }
    }

    /**
     * Ask for the user name.
     *
     * @return string
     */
    protected function name()
    {
        $value = $this->ask('What is your name?');

        if (! $value) {
            return $this->name();
        }

        return $value;
    }

    /**
     * Ask for user email.
     *
     * @return string
     */
    protected function email()
    {
        $value = $this->ask('What is your e-mail address?');

        if (! $value || ! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $this->email();
        }

        return $value;
    }

    /**
     * Ask for user password.
     *
     * @return string
     */
    protected function password()
    {
        $value = $this->secret('What is your password?');

        if (! $value) {
            return $this->password();
        }

        return $value;
    }

    /**
     * Ask for user role.
     *
     * @return string
     */
    protected function type()
    {
        $values = UserType::getValues();

        $choices = Arr::prepend($values, 'user');

        $value = $this->choice('What is your role?', $choices, 0);

        if (! $value) {
            return $this->type();
        }

        return $value;
    }
}
