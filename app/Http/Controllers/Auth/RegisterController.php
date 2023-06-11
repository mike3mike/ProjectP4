<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Address;
use App\Models\Client;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     * 
     */
    /**
     * o Een ingevoerde postcode wordt altijd als volgt geformatteerd en opgeslagen
             (we gaan in dit project uit van Nederlandse postcodes):
                        nnnn<spatie>MM, waarbij:
                    - nnnn 4 numerieke digits zijn
                    - de eerste digit van nnnn mag niet het digit 0 zijn
                    - hierna precies één spatie
                    - gevolgd door twee hoofdletters.

     */
    protected function validator(array $data)
{
    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'phoneNumber' => ['required', 'digits:10'],
        'role' => ['required', 'string', 'min:3'],
    ];

    if(isset($data['role']) && $data['role'] === 'opdrachtgever'){
        $rules['street'] = ['required', 'string', 'max:255'];
        $rules['city'] = ['required', 'string', 'max:255'];
        $rules['postal_code'] = ['required', 'string','regex:/^[1-9][0-9]{3}\s[A-Z]{2}$/'];
        $rules['house_number'] = ['required', 'numeric'];
        $rules['company_name'] = ['required', 'string', 'max:255'];
        $rules['billing_email'] = ['required', 'string', 'email', 'max:255'];
        $rules['contact_person'] = ['required', 'string', 'max:255'];
        $rules['contact_person_phone']=['required', 'digits:10'];
    }

    return Validator::make($data, $rules);
}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     * 
     */
protected function create(array $data)
{
    try {
    //    dd($data); 
        // Start a database transaction
        DB::beginTransaction();
      
        // User aanmaken
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phoneNumber'],
        ]);

   
            // Rol ophalen
            $role = Role::where('name', $data['role'])->firstOrFail();
            // Rol toewijzen aan gebruiker
            $user->roles()->attach($role);
           
           
        // Controleer of de rol van de gebruiker een 'opdrachtgever' is
        if ($data['role'] == 'opdrachtgever') {
            // Adres aanmaken
            $address = Address::create([
                'street_name' => $data['street'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'house_number' => $data['house_number'],
            ]);

            // Client aanmaken
            $client = new Client([
                'user_id' => $user->id,
                'company_name' => $data['company_name'],
                'invoice_email_address' => $data['billing_email'],
                'contact_person_name' => $data['contact_person'],
                'contact_person_phone_number' => $data['contact_person_phone'],
                'invoice_address_id' => $address->id,
            ]);

            // Client koppelen aan User
            $user->client()->save($client);
        }

        // If we reach here, it means that no exceptions were thrown.
        // So we can commit the transaction.
        DB::commit();

        return $user;
    } catch (\Exception $e) {
      // An error occurred. We must rollback the transaction.
      DB::rollBack();
      // Throw the exception
      throw $e;
    }
}
// wachten 
protected function registered(Request $request, $user)
{
    $this->guard()->logout();

    return redirect('/approval-pending');
}
}
