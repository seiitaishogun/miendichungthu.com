<?php

namespace Modules\Customer\Http\Controllers\Admin\Export;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Customer\Models\Customer;

class CustomerExport  implements FromCollection, WithHeadings
{
    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function collection()
    {
        $data = Customer::leftJoin('customer_addresses','customers.id','=','customer_addresses.customer_id')->get()->toArray();
        foreach ($data as $key => $value) {
            $result[$key]['id'] = $value['id'];
            $result[$key]['user_identifycation'] = $value['user_identifycation'];
            $result[$key]['prefix'] = $value['prefix'];
            $result[$key]['fullname'] = $value['first_name'].' '.$value['last_name'];
            //$result[$key]['sex'] = $value['sex'] == 1 ? trans('customer::language.mr',[],$this->locale) : trans('customer::language.mrs',[],$this->locale);
            $result[$key]['hospital'] = $value['hospital'];
            $result[$key]['province'] = $value['province'];
            $result[$key]['job'] = $value['job'];
            $result[$key]['specialists'] = $value['specialists'];
            $result[$key]['experience'] = $value['experience'];
            $result[$key]['email'] = $value['email'];
            $result[$key]['phone'] = "'".$value['phone'];
        }
        return collect($result);
    }
    //Thêm hàng tiêu đề cho bảng
    public function headings() :array {

    	return [
            'id',
            'MDM ID',
            trans('customer::language.appellation',[],$this->locale),
            trans('customer::language.fullname',[],$this->locale),
            trans('customer::language.hospital',[],$this->locale),
            trans('customer::language.province',[],$this->locale),
            trans('customer::language.job',[],$this->locale),
            trans('customer::language.specialists',[],$this->locale),
            trans('customer::language.experience',[],$this->locale),
            trans('customer::language.email',[],$this->locale),
            trans('customer::language.phone',[],$this->locale),
        ];
    }
}
