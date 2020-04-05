<?php

use App\User;
use App\Account;
use App\Employee;
use App\Organization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'Vritti Enterprise']);

        factory(User::class)->create([
            'account_id' => $account->id,
            'first_name' => 'Vimal',
            'last_name' => 'Vyas',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);

        factory(User::class, 5)->create(['account_id' => $account->id]);

        $organizations = factory(Organization::class, 3)
            ->create(['account_id' => $account->id]);

        factory(Employee::class, 15)
            ->create(['account_id' => $account->id])
            ->each(function ($employee) use ($organizations) {
                $employee->update(['organization_id' => $organizations->random()->id]);
            });
    }
}
