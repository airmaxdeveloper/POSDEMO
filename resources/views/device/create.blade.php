<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action([\App\Http\Controllers\DeviceController::class, 'store']), 'method' => 'post', 'id' => 'device_add_form']) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Add Device</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('device_serial_number', 'Serial Number:*') !!}
        {!! Form::text('device_serial_number', null, ['class' => 'form-control', 'required', 'placeholder' => 'Enter serial number']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('device_make', 'Device Make:*') !!}
        {!! Form::text('device_make', null, ['class' => 'form-control', 'required', 'placeholder' => 'e.g., pax']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('device_friendly_name', 'Friendly Name:*') !!}
        {!! Form::text('device_friendly_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'e.g., Terminal 1']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('cardknox_api_key', 'Cardknox API Key:*') !!}
        {!! Form::text('cardknox_api_key', null, ['class' => 'form-control', 'required', 'placeholder' => 'Enter Cardknox API Key']) !!}
      </div>

      {{-- Hidden fields: populated in controller after API response --}}
      {!! Form::hidden('device_id', null) !!}
      {!! Form::hidden('status', null) !!}
      {!! Form::hidden('ref_num', null) !!}
    </div>

    <div class="modal-footer">
      <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">@lang('messages.save')</button>
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang('messages.close')</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
