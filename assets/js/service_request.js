import { showFlash } from './show_flash.js';

export const listener  = {
    listen: function(){
        document.getElementById('service_request_employee').addEventListener('change', function () {
            const status = document.getElementById('service_request_status');
            status.value = this.value ? 'assigned' : 'created';
            showFlash(trans('flash.messages.employee_changed_update_status', {'%status%': trans('enum.service_request.status.'+status.value)}), 'info', 2000);
        });

        document.getElementById('service_request_guest').addEventListener('change', function () {
            const room_id = this.selectedOptions[0].dataset.room ?? '';
            const room = document.getElementById('service_request_room_number');
            room.value = room_id;

            showFlash(trans('flash.messages.guest_changed_update_room', {'%room%': room.value || '~'}), 'info', 2000);

        });
    }
};