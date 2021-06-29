import { Inertia } from '@inertiajs/inertia'
import { alertUser} from '../Plugins/alert'
export function handleInvalidResponse
  (callback = null,title = 'Success', message = 'Operation Completed', type = 'success') {
      Inertia.on('invalid', (e) => {
        const statusCode = e.detail.response.status
        if (statusCode === 500) {
          e.preventDefault()
          alertUser('Server Error', e.detail.response.statusText, 'error')
        } else if (statusCode === 404) {
          e.preventDefault()
          alertUser('Request Error', e.detail.response.statusText, 'warning')
        } else if (statusCode === 403) {
          e.preventDefault()
          alertUser('Permission Denied', 'Operation Not Allowed', 'warning')
        } else {
            e.preventDefault()
            alertUser(title, message, type).then(() => {
              if (callback) {
                callback(e.detail.response.data)
              }
            })
        }
      })
    }

