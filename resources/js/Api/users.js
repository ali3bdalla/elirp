import {Inertia} from '@inertiajs/inertia';
import {handleInvalidResponse} from './inertiajs'

export function saveUser(context,form) {
	Inertia.post(route('api.users.store'),form);
	handleInvalidResponse(context);
}
