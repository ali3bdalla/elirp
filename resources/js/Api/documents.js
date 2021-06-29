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
	handleInvalidResponse(successCallback, 'Received', 'Document Has Been Received');
}


export function paid(id, successCallback = null) {
	Inertia.put(route('api.documents.paid', id));
	handleInvalidResponse(successCallback, 'Paid', 'Document Has Been Marked As Paid');
}



export function refunded(id, successCallback = null) {
	Inertia.put(route('api.documents.refunded', id));
	handleInvalidResponse(successCallback, 'Refunded', 'Document Has Been Marked As Refunded');
}



export function delivered(id, successCallback = null) {
	Inertia.put(route('api.documents.delivered', id));
	handleInvalidResponse(successCallback, 'Delivered', 'Document Has Been Delivered');
}


export function billReturn(id, successCallback = null) {
	Inertia.put(route('api.documents.bill_returned', id));
	handleInvalidResponse(successCallback, 'Returned', 'Document Has Been Marked As Returned');
}



export function invoiceReturn(id, successCallback = null) {
	Inertia.put(route('api.documents.invoice_returned', id));
	handleInvalidResponse(successCallback, 'Returned', 'Document Has Been Marked As Returned');
}
