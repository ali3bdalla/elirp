import { Inertia } from '@inertiajs/inertia';
import { handleInvalidResponse } from '../Plugins/inertiajs'
export function save(form, successCallback = null) {
	Inertia.post(route('api.documents.store'), form);
	handleInvalidResponse(successCallback, 'Created', 'Document has been Created');
}
export function update(form, id, successCallback = null) {
	Inertia.put(route('api.documents.update', id), form);
	handleInvalidResponse(successCallback, 'Updated', 'Document has been Updated');
}


export function received(id, successCallback = null) {
	Inertia.put(route('api.documents.received', id));
	handleInvalidResponse(successCallback, 'Updated', 'Document Has Been Received');
}
