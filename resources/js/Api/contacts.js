import { Inertia } from '@inertiajs/inertia';
import { handleInvalidResponse } from './../Plugins/inertiajs'
export function saveContact(form, successCallback = null) {
	Inertia.post(route('api.contacts.store'), form);
	handleInvalidResponse(successCallback, 'Created', 'Contact has been Created');
}
export function updateContact(form, contactId, successCallback = null) {
	Inertia.put(route('api.contacts.update', contactId), form);
	handleInvalidResponse(successCallback, 'Updated', 'Contact has been Updated');
}
