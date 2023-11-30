<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AccountClass;
use App\Models\Referral;
use App\Models\State;
use App\Models\User;
use App\Models\Postcode;

class IncomingCall extends Component
{
    public $business_name = '';
    public $abn = '';
    public $business_phone = '';
    public $first_name = '';
    public $last_name = '';
    public $street_address = '';
    public $email = '';
    public $username = '';
    public $home_phone = '';
    public $mobile_phone = '';

    public function mount() {
        // Business name.
        if (old('business_name')) {
            $this->business_name = old('business_name');
        }
        // abn.
        if (old('abn')) {
            $this->abn = old('abn');
        }
        // business_phone.
        if (old('business_phone')) {
            $this->business_phone = old('business_phone');
        }
        // first_name.
        if (old('first_name')) {
            $this->first_name = old('first_name');
        }
        // last_name.
        if (old('last_name')) {
            $this->last_name = old('last_name');
        }
        // street_address.
        if (old('street_address')) {
            $this->street_address = old('street_address');
        }
        // email.
        if (old('email')) {
            $this->email = old('email');
        }
        // username.
        if (old('username')) {
            $this->username = old('username');
        }
        // home_phone.
        if (old('home_phone')) {
            $this->home_phone = old('home_phone');
        }
        // mobile_phone.
        if (old('mobile_phone')) {
            $this->mobile_phone = old('mobile_phone');
        }
        // referral_id.
        if (old('referral_id')) {
            $this->referral_id = old('referral_id');
        }
        // account_classid.
        if (old('account_class_id')) {
            $this->account_class_id = old('account_class_id');
        }
    }

    public function render()
    {
        // All referrals
        $all_referrals = Referral::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Get all customer account classes.
        $all_account_classes = AccountClass::whereNotBetween('id', [1, 2]) // Only non staff account classes.
            ->select('id', 'title')
            ->withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();
        // Get all states.
        $all_states = State::all('id', 'title');
        // Get all suburbs.
        $all_suburbs = Postcode::all('id', 'title', 'code');
        // Check if all variables are null.
        if ($this->business_name == null && $this->abn == null && $this->business_phone == null && $this->first_name == null && $this->last_name == null && $this->street_address == null && $this->email == null && $this->username == null && $this->home_phone == null && $this->mobile_phone == null) {
            // Set the users value to an empty array as all inputs are null.
            $users = [];
        } else {
            // Search for all the required users.
            $users = User::where('account_role_id', 5)->where(function($q) {
                // Business Name.
                if ($this->business_name != null) {
                    $q->where('business_name','LIKE','%'.$this->business_name.'%');
                }
                // Abn.
                if ($this->abn != null) {
                    $q->where('abn','LIKE','%'.$this->abn.'%');
                }
                // Busines Phone.
                if ($this->business_phone != null) {
                    $q->where('business_phone','LIKE','%'.$this->business_phone.'%');
                }
                // First Name.
                if ($this->first_name != null) {
                    $q->where('first_name','LIKE','%'.$this->first_name.'%');
                }
                // Last Name.
                if ($this->last_name != null) {
                    $q->where('last_name','LIKE','%'.$this->last_name.'%');
                }
                // Street Address
                if ($this->street_address != null) {
                    $q->where('street_address','LIKE','%'.$this->street_address.'%');
                }
                // Email
                if ($this->email != null) {
                    $q->where('email','LIKE','%'.$this->email.'%');
                }
                // Email
                if ($this->username != null) {
                    $q->where('username','LIKE','%'.$this->username.'%');
                }
                // Home Phone
                if ($this->home_phone != null) {
                    $q->where('home_phone','LIKE','%'.$this->home_phone.'%');
                }
                // Mobile Phone
                if ($this->mobile_phone != null) {
                    $q->where('mobile_phone','LIKE','%'.$this->mobile_phone.'%');
                }
            })->limit(15)->get();
        }
        // Return the view.
        return view('livewire.incoming-call', [
            'users' => $users,
            'all_account_classes' => $all_account_classes,
            'all_referrals' => $all_referrals,
            'all_states' => $all_states,
            'all_suburbs' => $all_suburbs
        ]);
    }
}
