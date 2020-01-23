<?php

namespace App\Http\Controllers\Site;

use App\Address;
use App\Http\Controllers\Controller;
use App\Phone;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('site.create_user');
    }

    public function ajaxCreateUser(Request $request)
    {
        $json = array();


        if (empty($request->user_name)) {
            $json['id']['#user_name'] = "";
        }

        if (empty($request->user_lastname)) {
            $json['id']['#user_lastname'] = "";
        }

        if (empty($request->user_email)) {
            $json['id']['#user_email'] = "";
        }

        if (empty($request->user_birthdate)) {
            $json['id']['#user_birthdate'] = "";
        }

        if (empty($request->user_zip)) {
            $json['id']['#user_zip'] = "";
        }

        if (empty($request->user_public_place)) {
            $json['id']['#user_public_place'] = "";
        }

        if (empty($request->user_number)) {
            $json['id']['#user_number'] = "";
        }

        if (empty($request->user_district)) {
            $json['id']['#user_district'] = "";
        }

        if (empty($request->user_city)) {
            $json['id']['#user_city'] = "";
        }

        if (empty($request->user_state)) {
            $json['id']['#user_state'] = "";
        }

        if (empty($request->user_phones)) {
            $json['id']['#user_phone_01'] = "";
        }

        $data['user'] = [
            'name' => $request->user_name,
            'lastname' => $request->user_lastname,
            'email' => $request->user_email,
            'birthdate' => $this->convertDate($request->user_birthdate),
        ];

        if (!empty($json['id'])) {
            $json['status'] = 0;
            $json['message'] = "Os campos em vermelho são obrigatórios";
        } else {
            try {
                $insertUser = User::create($data['user']);
                if ($insertUser) {
                    $data['address'] = [
                        'zip' => $this->replaceCaracter($request->user_zip),
                        'public_place' => $request->user_public_place,
                        'number' => $request->user_number,
                        'complement' => $request->user_complement,
                        'district' => $request->user_district,
                        'city' => $request->user_city,
                        'state' => $request->user_state
                    ];
                    $insertAddress = $this->ajaxCreateAddress($data['address'], $insertUser->id);
                    $insertPhone = $this->ajaxCreatePhone($request->user_phones, $insertUser->id);
                    if ($insertPhone and $insertAddress) {
                        $json['status'] = 1;
                        $json['message'] = "Cadastro realizado com sucesso";
                    }
                }
            } catch (\Exception $e) {
                $json['status'] = 0;
            }
        }

        return response()->json($json);
    }

    public function ajaxCreateAddress($data, $user_id)
    {
        $insertAddress = Address::create($data);
        $attach_address = User::find($user_id);
        $attach_address->addresses()->attach($insertAddress->id);

        return $attach_address;
    }

    public function ajaxCreatePhone($data, $user_id)
    {
        foreach ($data as $user_phone) {
            if (!empty($user_phone)) {
                $dddPhone = explode(' ', $user_phone);
                if (!empty($dddPhone[0])) {
                    $ddd = $dddPhone[0];
                }
                if (!empty($dddPhone[1])) {
                    $phone = $dddPhone[1];
                }
                $data['phone'] = [
                    'ddd' => $this->replaceCaracter($ddd),
                    'phone' => $this->replaceCaracter($phone),
                ];

                $insertPhone = Phone::create($data['phone']);

                $attach_phone = User::find($user_id);
                $attach_phone->phones()->attach($insertPhone->id);
            }
        }
        return $attach_phone;
    }

    public function replaceCaracter($string)
    {
        $values = [' ', '(', ')', '-', '.'];
        $string = str_replace($values, '', $string);
        return $string;
    }

    public function convertDate($date)
    {
        $date = str_replace('/', '-', $date);
        $date = date('Y-m-d', strtotime($date));
        return $date;
    }

    public function userList()
    {
        return view('api.list_users');
    }
}
