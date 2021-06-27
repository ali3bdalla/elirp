import {Inertia} from '@inertiajs/inertia';
import { alertUser } from '../Plugins/alert'
export function logout() {
	// Inertia.post(route('logout'));
	alertUser('Logout','Logout Completed','info').then(res => {
		Inertia.visit(route('login'));
	})
}

