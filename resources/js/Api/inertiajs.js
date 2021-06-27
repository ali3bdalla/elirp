import { Inertia } from '@inertiajs/inertia'
import { alertUser} from '../Plugins/alert'
export function handleInvalidResponse
 (context,url = null, title = 'Success', message = 'Operation Completed', type = 'success', skipOnSuccess = false) {
      Inertia.on('invalid', (e) => {
        const statusCode = e.detail.response.status
        if (statusCode === 500) {
          e.preventDefault()
          alertUser(context,'Server Error', e.detail.response.statusText, 'error')
        } else if (statusCode === 404) {
          e.preventDefault()
          alertUser(context,'Request Error', e.detail.response.statusText, 'warning')
        } else if (statusCode === 403) {
          e.preventDefault()
          alertUser(context,'Permission Denied', 'Operation Not Allowed', 'warning')
        } else {
          if (!skipOnSuccess) {
            e.preventDefault()
            alertUser(context,title, message, type).then(() => {
              if (url) {
                Inertia.visit(url)
              }
            })
          }
        }
      })
    }

