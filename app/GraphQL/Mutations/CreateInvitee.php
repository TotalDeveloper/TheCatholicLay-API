<?php

namespace App\GraphQL\Mutations;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInvite;
use App\Models\FormTemplate;
use App\Models\Form;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Exception;

final class CreateInvitee
{
    /**
     * @param null $_
     * @param array{} $args
     * @throws ValidationException
     * @throws Exception
     */
    public function __invoke($_, array $args): array
    {
        $firstName = $args['firstName'];
        $middleName = $args['middleName'];
        $lastName = $args['lastName'];
        $password = $args['password'];
        $token = $args['token'];

        $invite = UserInvite::where("token", "=", $token)->first();
        if (!Arr::get($invite, "token", false)) {
            return [
                "token" => "Invalid token",
                "email" => "",
                "firstName" => "",
                "middleName" => "",
                "lastName" => "",
                "role" => "",
                "message" => "",
            ];
        }

        $user = User::where('email', Arr::get($invite, "email", ""))->first();
        if (!$user) {
            $user = new User();
            $user->name = $firstName . " " . $lastName;
            $user->email = Arr::get($invite, "email", "");
            $user->password = Hash::make($password);
            $user->phone_number = "...";
            $user->device_name = "web";
            $user->save();
        }

        // Begin: Add new user.
        if (Arr::get($invite, "role_id", null)) {
            $user->assignRole(Role::find(Arr::get($invite, "role_id", null)));
        }

        if (Arr::get($invite, "organization_id", null)) {
            $user->organizations()->attach(Arr::get($invite, "organization_id", null));
        }

        if (Arr::get($invite, "team_id", null)) {
            $user->teams()->attach(Arr::get($invite, "team_id", null));
        }


        $parent = User::find(Arr::get($invite, "admin_id", null));
        $parent->children()->save($user);

        if ($invite["role_id"] == Role::ADMIN) {
            $admin = new Admin();
            $admin->id = $user->id;
            $admin->save();
        }
        // End: Add new user.


        // Assign User to its Formtemplate and Forms according to its team

        // GET TEMPLATE
        $teamFormTemplates = FormTemplate::whereHas('teams', function (Builder $query) use ($invite) {
            $query->where('id', Arr::get($invite, "team_id", null));
        })->with(['users','form'])->get();

        // GET FORM WHERE THE TEMPLATE IS STRUCTURED
        $teamFormTemplatesCreatedFrom = Form::whereIn('id', Arr::pluck($teamFormTemplates, "form_id", null))->get();

        if (Arr::pluck($teamFormTemplates, "id", null)) {
            $user->formTemplates()->attach(Arr::pluck($teamFormTemplates, "id", null));
            $user->forms()->attach(Arr::pluck($teamFormTemplatesCreatedFrom, "id", null));
        }
        
        //End: Assign User to its Formtemplate and Forms according to its team

        UserInvite::where("token", "=", $token)->update([
            'status' => 'accepted'
        ]);

        $sanctumToken = Str::random(40);

        return [
            "token" => $user->createToken("web", $sanctumToken)->plainTextToken,
            "email" => $user->email,
            "firstName" => $firstName,
            "middleName" => $middleName,
            "lastName" => $lastName,
            "role" => $invite["role_id"],
            "message" => "",
        ];
    }
}
