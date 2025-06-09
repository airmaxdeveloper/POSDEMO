<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action([\App\Http\Controllers\DeviceController::class, 'update'], ['device' => $device->id]), 'method' => 'put', 'id' => 'device_edit_form']) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Edit Device</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('device_serial_number', 'Serial Number:*') !!}
        {!! Form::text('device_serial_number', $device->device_serial_number, ['class' => 'form-control', 'required', 'placeholder' => 'Enter serial number']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('device_make', 'Device Make:*') !!}
        {!! Form::text('device_make', $device->device_make, ['class' => 'form-control', 'required', 'placeholder' => 'e.g., pax']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('device_friendly_name', 'Friendly Name:*') !!}
        {!! Form::text('device_friendly_name', $device->device_friendly_name, ['class' => 'form-control', 'required', 'placeholder' => 'e.g., Terminal 1']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('cardknox_api_key', 'Cardknox API Key:*') !!}
        {!! Form::text('cardknox_api_key', $device->cardknox_api_key, ['class' => 'form-control', 'required', 'placeholder' => 'Enter Cardknox API Key']) !!}
      </div>

      {{-- Hidden fields: populated in controller after API response --}}
      {!! Form::hidden('device_id', $device->device_id) !!}
      {!! Form::hidden('status', $device->status) !!}
      {!! Form::hidden('ref_num', $device->ref_num) !!}
    </div>

    <div class="modal-footer">
      <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">@lang('messages.save')</button>
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang('messages.close')</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->