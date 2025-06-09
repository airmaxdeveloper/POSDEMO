<!-- Cardknox Device Selection Modal -->
<div class="modal fade" id="cardknox_device_modal" tabindex="-1" role="dialog" aria-labelledby="cardknoxDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardknoxDeviceModalLabel">Select Cardknox Device</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="cardknox_device">Select Device:</label>
                    <select class="form-control" id="cardknox_device">
                        <option value="">Select a device</option>
                        @foreach($devices as $device)
                            <option value="{{ $device->id }}">{{ $device->device_serial_number }} - {{ $device->device_friendly_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="proceed_payment" disabled>Proceed to Payment</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initially disable the proceed button
        $('#proceed_payment').prop('disabled', true);
        
        // Add change event listener to the device select
        $('#cardknox_device').on('change', function() {
            // Enable/disable proceed button based on selection
            $('#proceed_payment').prop('disabled', !$(this).val());
        });
    });
</script> 