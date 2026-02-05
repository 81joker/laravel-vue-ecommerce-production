export function setUser(state, user) {
    state.user.data = user
}

export function setToken (state, token) {
    state.user.token = token
    if (token){
        sessionStorage.setItem('TOKEN', token)
    } else {
        sessionStorage.removeItem('TOKEN')
    }
}

export function setProducts (state, [loading,response = null]) {
    if(response){
        state.products = {
          ...state.products,
            data:response.data,
            links: response.meta.links,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
            limit: response.meta.per_page,
            total: response.meta.total,
        }
        }
    state.products.loading = loading
    // state.products.data = response.data
}



// Set Users
export function setUsers (state, [loading,response = null]) {
    if(response){
        state.users = {
          ...state.users,
            data:response.data,
            links: response.meta.links,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
            limit: response.meta.per_page,
            total: response.meta.total,
        }
        }
    state.users.loading = loading
    // state.products.data = response.data
}
// Set Customers
export function setCustomers (state, [loading,response = null]) {
    if(response){
        state.customers = {
          ...state.customers,
            data:response.data,
            links: response.meta.links,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
            limit: response.meta.per_page,
            total: response.meta.total,
        }
        }
    state.customers.loading = loading
    // state.products.data = response.data
}





// Set Orders
export function setOrders (state, [loading,response = null]) {
    if(response){
        state.orders = {
          ...state.orders,
            data:response.data,
            links: response.meta.links,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
            limit: response.meta.per_page,
            total: response.meta.total,
        }
        }
    state.orders.loading = loading
    // state.products.data = response.data
}


export function showToast(state, message) {
    state.toast.show = true;
    state.toast.message = message;
}
export function hideToast(state, message) {
    state.toast.show = true;
    state.toast.message = message;
}


export function setCountries (state, countries) {
    state.countries = countries.data
}

export function setCategories(state, [loading, data = null]) {

    if (data) {
      state.categories = {
        ...state.categories,
        data: data.data,
      }
    }
  
    state.categories.loading = loading;
  }