<?php

namespace App\GraphQL\Mutations;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Illuminate\Support\Facades\Hash;

class CreateSubscriptionStripe
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @throws \Exception
     */
    public function __invoke($_, array $args): array
    {
        // TODO implement the resolver
        $resolver = [
            'status' => '00',
            'message' => ''
        ];

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $args['fullname'];
            $user->email = $args['email'];
            $user->phone_number = $args['mobile_number'];
            $user->password = Hash::make($args['password']);
            $user->save();

            $admin_user = new \App\Models\Admin();
            $admin_user->user()->associate($user);
            $admin_user->save();

            $admin_group= new \App\Models\Group();
            $admin_group->name = 'Default';
            $admin_group->admin()->associate($admin_user);
            $admin_group->save();

            $organization = new Organization();
	        $organization->name = $args['organization'];
	        $organization->admin()->associate($admin_user);
            $organization->save();

            $user->newSubscription('default', $args['plan'])->create($args['payment_method']);

            DB::commit();

            $resolver['success'] = '00';
            $resolver['message'] = 'Successful!';
        } catch (PaymentActionRequired | PaymentFailure $e) {

            DB::rollBack();

            $resolver['success'] = '-2';
            $resolver['message'] = $e->getMessage();
        }

        return $resolver;
    }
}
