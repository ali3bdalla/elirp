import Swal from "sweetalert2";
import Vue from 'vue';
import { usePage } from '@inertiajs/inertia-vue3'
export async function alertUser(title = null, message = null, type = 'error') {
	if (title === null) { title = usePage().props.value?.locale?.app.confirm }
	if (message === null) { message = usePage().props.value?.locale?.app.are_you_sure }

	return new Promise((resolve, reject) => {
		Swal.fire(message, title, type).then(res => resolve(res))
	});
};
export async function askUser(title = null, message = null, iconType = 'question') {

	if (title === null) { title = usePage().props.value?.locale?.app.confirm }
	if (message === null) { message = usePage().props.value?.locale?.app.are_you_sure }
	return new Promise((resolve, reject) => {
		Swal.fire({
			icon: iconType,
			title: title,
			text: message,
			showCancelButton: true,
			confirmButtonColor: "#17a673",
			confirmButtonText: usePage().props.value?.locale?.app.yes,
			cancelButtonText: usePage().props.value?.locale?.app.no,
		}).then(res => resolve(res))
	});
};
