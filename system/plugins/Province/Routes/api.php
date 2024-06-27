<?php
use Collective\Html\FormFacade as Form;

Route::group([
    'middleware' => ['api'],
    'prefix' => 'api'
], function () {
    Route::get('/provinces.json', function (\Illuminate\Http\Request $request) {
        $provinces = \Plugins\Province\Models\Province::where('activated', 1)->get();
        $provinceSelected = $request->get('provinceSelected');
        $name = $request->get('name') ?: 'province';

        if ($request->exists('form')) {

            return Form::select($name, $provinces->mapWithKeys(function ($province, $key) use($provinceSelected) {
                $name = $province->type . ' ' . $province->name;
                if($provinceSelected && $provinceSelected != 'undefined') {
                    return ['' => 'Tỉnh/Thành phố', $provinceSelected => $provinceSelected, $name => $name];
                } else {
                    if ($key == 0) {
                        return ['' => 'Tỉnh/Thành phố', $name => $name];
                    } else {
                        return [$name => $name];
                    }
                }
            }), (@$provinceSelected ?:$request->get('province')), ['class' => 'form-control']);
        } else {
            return response()->json($provinces->toArray());
        }
    });

    Route::get('/districts.json', function (\Illuminate\Http\Request $request) {
        $districts = \Plugins\Province\Models\District::query();
        $name = $request->get('name') ?: 'district';
        $districtSelected = $request->get('districtSelected');

        if($request->has('province'))
        {
            $province =\Plugins\Province\Models\Province::select('id')
                ->where('activated', true)
                ->where('name', 'like', getOriginName('province'))->first();

            if($province) {
                $districts = $districts->where('province_id', $province->id);
            }
        }
        $districts = $districts->orderBy('name')->get();

        if($request->exists('form')) {
            return Form::select($name, $districts->mapWithKeys(function ($district, $key) use ($districtSelected) {
                $name = $district->type . ' ' . $district->name;

                if($districtSelected && $districtSelected != 'undefined') {
                    return ['' => 'Quận / Huyện', $districtSelected => $districtSelected, $name => $name];
                } else {
                    if ($key == 0) {
                        return ['' => 'Quận / Huyện',$name => $name];
                    } else {
                        return [$name => $name];
                    }
                }

            }), (@$districtSelected ?:$request->get('district')), ['class' => 'form-control']);
        } else {
            return response()->json($districts->toArray());
        }
    });

    Route::get('/wards.json', function (\Illuminate\Http\Request $request) {
        $wards = \Plugins\Province\Models\Ward::query();

        if($request->has('district'))
        {
            $district =\Plugins\Province\Models\District::select('id')->where('name', 'like', getOriginName('district'))->first();
            if($district) {
                $wards = $wards->where('district_id', $district->id);
            }
        }

        $wardSelected = $request->get('wardSelected');

        $wards = $wards->orderBy('name')->get();

        if($request->exists('form')) {
            return Form::select('ward', $wards->mapWithKeys(function ($ward, $key) use ($wardSelected) {
                $name = $ward->type . ' ' . $ward->name;

                if($wardSelected && $wardSelected != 'undefined') {
                    return ['' => 'Phường / Xã', $wardSelected => $wardSelected, $name => $name];
                } else {
                    if ($key == 0) {
                        return ['' => 'Phường / Xã',$name => $name];
                    } else {
                        return [$name => $name];
                    }
                }
            }), (@$wardSelected ?:$request->get('ward')), ['class' => 'form-control']);
        } else {
            return response()->json($wards->toArray());
        }
    });
});

function getOriginName($attribute)
{
    $name = request()->get($attribute);
    $name = str_replace(['Thành Phố', 'Tỉnh', 'Quận', 'Huyện', 'Thị Xã'], '', $name);
    return '%' . trim($name) . '%';
}
