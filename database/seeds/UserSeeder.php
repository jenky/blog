<?php

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = $this->name();
        $email = $this->email();
        $password = $this->password();
        $type = $this->type();

        $confirm = $this->command->confirm(
            sprintf('Create new user: %s - %s | %s', $name, $email, $type)
        );

        if ($confirm) {
            $type = $type == 'user' ? null : $type;
            if ($user = User::create(compact('name', 'email', 'password', 'type'))) {
                $this->command->info('Successfully create user: '.$user->name);
            } else {
                $this->command->error('Unable to create new user. Please try again.');
            }
        } else {
            $this->command->comment('Aborted!');
        }
    }

    /**
     * Ask for the user name.
     *
     * @return string
     */
    protected function name()
    {
        $value = $this->command->ask('What is your name?');

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
        $value = $this->command->ask('What is your e-mail address?');

        // TODO: Validate email address

        if (! $value) {
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
        $value = $this->command->secret('What is your password?');

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

        $value = $this->command->choice('What is your role?', $choices, 0);

        if (! $value) {
            return $this->type();
        }

        return $value;
    }
}
