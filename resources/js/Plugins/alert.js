import Swal from "sweetalert2";
import VueSweetalert2 from "vue-sweetalert2";
export async function alertUser(title = null, message = null, type = 'error') {
	if (title === null) { title = `confirm` }
	if (message === null) { message = `are you sure?` }

	return new Promise((resolve, reject) => {
		Swal.fire(message, title, type).then(res => resolve(res))
	});
};
export async function askUser(title = null, message = null, iconType = 'question') {
	if (title === null) { title = `confirm` }
	if (message === null) { message = `are you sure?` }
	return new Promise((resolve, reject) => {
		Swal.fire({
			icon: iconType,
			title: title,
			text: message,
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes!",
			cancelButtonText: "No !",
		}).then(res => resolve(res))
	});
};
export async function notifyUser(title = null, message = null, type = 'error') {
	if (title === null) { title = `confirm` }
	if (message === null) { message = `are you sure?` }
	return context.$notify({
		title: title,
		message: message,
		type: type

	})
};
export async function messageUser(message = 'Message', type = 'error') {
	return this.$message({
		message: message,
		type: type
	})
};
