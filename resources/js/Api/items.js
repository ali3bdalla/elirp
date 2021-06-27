import { Inertia } from '@inertiajs/inertia';
import { handleInvalidResponse } from './../Plugins/inertiajs'
export function saveItem(form, successCallback = null) {
	Inertia.post(route('api.items.store'), form);
	handleInvalidResponse(successCallback, 'Created', 'Item has been Created');
}
export function updateItem(form, userId, successCallback = null) {
	Inertia.put(route('api.items.update', userId), form);
	handleInvalidResponse(successCallback, 'Updated', 'Item has been Updated');
}
