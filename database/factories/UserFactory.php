<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $countries       = collect(json_decode(file_get_contents(resource_path('views/partials/country.json'))));
        $countryCodes    = $countries->pluck('dial_code')->toArray();

        $countryCode     = $countryCodes[array_rand($countryCodes)];
        $countryArray    = $countries->where('dial_code', $countryCode)->take(1)->toArray();
        $shortName       = array_keys($countryArray)[0];
        $countryName     = $countryArray[$shortName]->country;

        $address       = [
            'address' => '',
            'state'   => '',
            'zip'     => '',
            'country' => $countryName,
            'city'    => ''
        ];

        return [
            'firstname'      => $this->faker->firstName,
            'lastname'       => $this->faker->lastName,
            'username'       => $this->faker->unique()->userName,
            'email'          => $this->faker->unique()->safeEmail,
            'country_code'   => $shortName,
            'mobile'         => $countryCode.random_int(1111111111, 9999999999),
            'password'       => Hash::make('123456'),
            'ev'             => 1,
            'sv'             => 1,
            'address'        => $address,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
