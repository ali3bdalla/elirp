import { ApolloClient } from 'apollo-client'
import { createHttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
// HTTP connection to the API
const httpLink = createHttpLink({
    // You should use an absolute URL here
    // http://127.0.0.1:3000
    uri: `/graphql`,
    headers: {
        'X-CSRF-TOKEN': csrfToken
    }
})

// Cache implementation
const cache = new InMemoryCache()

// Create the apollo client
export default new ApolloClient({
    link: httpLink,
    cache,
})

