import Swal from "sweetalert2";
export async function alertUser(title = null, message = null, type = 'error') {
	if (title === null) { title = `confirm` }
	if (message === null) { message = `are you sure?` }
	return Swal.fire(message, title, type)
};
export async function askUser(title = null, message = null, type = 'error') {
	if (title === null) { title = `confirm` }
	if (message === null) { message = `are you sure?` }
	return context.$confirm(message, title, type, {
		confirmButtonText: 'تاكيد',
		cancelButtonText: 'الغاء',
	})
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
