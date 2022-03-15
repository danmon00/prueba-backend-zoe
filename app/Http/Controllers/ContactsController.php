<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Traits\HubSpotService;
use Illuminate\Http\Request;

class ContactsController extends Controller
{

    use HubSpotService;

    public function fetch(){
        $data = $this->getContacts();
        $result = Contact::query()->insert($data);
        if($result){
            return response()->json(['msg'=>'ok']);
        }else{
            return response()->json(['msg'=>'error guardando']);
        }
    }

    public function index(Request $request){
        $query = Contact::query();
        if($request->has('email')) {
            $query->where('email', $request->get('email'));
        }
        return $query->get();
    }
}
