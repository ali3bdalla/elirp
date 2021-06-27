import {Inertia} from '@inertiajs/inertia';
import { handleInvalidResponse } from './../Plugins/inertiajs'

export function saveUser(form,successCallback = null) {
	Inertia.post(route('api.users.store'),form);
	handleInvalidResponse(successCallback, 'Created', 'User has been Created');
}
export function updateUser(form,userId,successCallback = null) {
	Inertia.put(route('api.users.update',userId),form);
	handleInvalidResponse(successCallback,'Updated','User has been Updated');
}
