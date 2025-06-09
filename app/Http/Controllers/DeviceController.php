<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{
    public function __construct(){}

    public function index()
    {
        if (! auth()->user()->can('tax_rate.view') && ! auth()->user()->can('tax_rate.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            \Log::info('inside the ajax call');
            $business_id = request()->session()->get('user.business_id');

            $devices = Device::where('user_id', auth()->id())
                ->select([
                    'id',
                    'device_serial_number',
                    'device_make',
                    'device_friendly_name',
                    'device_id',
                    'created_at',
                    'updated_at'
                ])->get();

            $data =  Datatables::of($devices)
                ->addColumn(
                    'action',
                    '<button data-href="{{action(\'App\Http\Controllers\DeviceController@destroy\', [$id])}}" class="tw-dw-btn tw-dw-btn-outline tw-dw-btn-xs tw-dw-btn-error delete_device_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>'
                )
                ->removeColumn('id')
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns([0,4])
                ->make(false);                
                
                return $data;
        }        

        return view('device.index');
    }
    public function create(){
         if (! auth()->user()->can('tax_rate.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('device.create');
    }
    public function store(Request $request)
    {
        if (! auth()->user()->can('tax_rate.create')) {
            abort(403, 'Unauthorized action.');
        }

        DB::beginTransaction();

        try {
            $input = $request->only(['device_serial_number', 'device_make', 'device_friendly_name', 'cardknox_api_key']);
            $input['user_id'] = auth()->id();
            
            // Call Cardknox Device API
            $response = Http::withHeaders([
                'Authorization' => $input['cardknox_api_key'],
                'Content-Type' => 'application/json',
            ])->post('https://device.cardknox.com/v1/Device', [
                'xDeviceSerialNumber' => $input['device_serial_number'], // Use xDeviceSerialNumber
                'xDeviceMake' => $input['device_make'], // Use xDeviceMake
                'xDeviceFriendlyName' => $input['device_friendly_name'], // Use xDeviceFriendlyName
            ]);

            $data = $response->json();

            // Check if Cardknox responded successfully
            if (!isset($data['xResult']) || $data['xResult'] !== 'S') {
                throw new \Exception('Device registration failed. Response: ' . json_encode($data));
            }

            // Add data from Cardknox to $input
            $input['device_id'] = $data['xDeviceId'];
            $input['status'] = 'Active';

            

            // Create device record
            $device = Device::create($input);

            DB::commit();

            return [
                'success' => true,
                'data' => $device,
                'msg' => __('Device added successfully'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Device store error: " . $e->getMessage());

            return [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }
    }
    public function edit($id)
    {
        if (! auth()->user()->can('tax_rate.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {            
            $device = Device::findOrFail($id);

            return view('device.edit')
                ->with(compact('device'));
        }
    }
    public function update(){
        \Log::Info('update');
    }
    public function destroy($id)
    {
        if (! auth()->user()->can('tax_rate.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $device = Device::where('id', $id)->findOrFail($id);
                $device->delete();
                
                $output = [
                    'success' => true,
                    'msg' => __('Device deleted successfully')
                ];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong')
                ];
            }

            return $output;
        }
    }
}
