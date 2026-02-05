import axiosClient from "../axios";

export function getUser({ commit }) {
    return axiosClient.get("/user").then(({ data }) => {
        commit("setUser", data.user);
        return data;
    });
}

export function login({ commit }, data) {
    return axiosClient.post("/login", data).then(({ data }) => {
        commit("setUser", data.user);
        commit("setToken", data.token);
        return data;
    });
}

export async function logout({ commit }) {
    try {
        const response = await axiosClient.post("/logout");
        commit("setToken", null); // Clear the token from the store
        return response; // Return the response if needed
    } catch (error) {
        console.error("Logout failed:", error); // Log the error for debugging
        throw error; // Re-throw the error for further handling
    }
}

export function getCountries({commit}) {
    return axiosClient.get('countries')
      .then(({data}) => {
        commit('setCountries', data)
      })
  }

export function getProducts(
    { commit },
    { url = null, search = "", perPage, sort_field, sort_direction } = {}
) {
    commit("setProducts", [true]);
    url = url || "/products";
    return axiosClient
        .get(url, {
            params: {
                search: search,
                per_page: perPage,
                sort_field: sort_field,
                sort_direction: sort_direction,
            },
        })

        .then((res) => {
            commit("setProducts", [false, res.data]);
        })
        .catch(() => {
            commit("setProducts", [false]);
        });
}


export function getProduct({commit}, id) {
    return axiosClient.get(`/products/${id}`)
  }




// export function createProduct({ commit }, product) {
//     if (product.images && product.images.length) {
//         // This is for just one mage
//     // if (product.image instanceof File) {
//         const form = new FormData();
//         form.append("title", product.title);
//         // This is for just one mage
//         // form.append("image", product.image);
//         product.images.forEach((im) => {
//             form.append("images[]", im);
//         });
//         if(product.deleted_images && product.deleted_images.length) {
//             product.deleted_images.forEach((im) => {
//                 form.append("deleted_images[]", im);
//             });
//         }
//         form.append("description", product.description);
//         form.append("price", product.price);
//         form.append("published", product.published ? 1 : 0);
//           // Append categories as JSON array
//   form.append('categories', product.categories || []);
// //   formData.append('categories', JSON.stringify(product.categories || []));
//         product = form;
//     }
//     return axiosClient.post("/products", product);
// }

export function createProduct({ commit }, product) {
    const form = new FormData();

    // Append basic fields
    form.append("title", product.title);
    form.append("description", product.description);
    form.append("price", product.price);
    form.append("published", product.published ? 1 : 0);
    form.append("quantity", product.quantity);

    // Handle categories - ensure it's always an array and properly stringified
    const categories = Array.isArray(product.categories) ? product.categories : [];
    form.append("categories", JSON.stringify(categories));

    // Handle images
    if (product.images && product.images.length) {
        product.images.forEach((im) => {
            if (im instanceof File) {
                form.append("images[]", im);
            }
        });
    }

    // Handle deleted images
    if (product.deleted_images && product.deleted_images.length) {
        product.deleted_images.forEach((im) => {
            form.append("deleted_images[]", im);
        });
    }

    // Debug output (remove in production)
    for (let [key, value] of form.entries()) {
        console.log(key, value);
    }

    return axiosClient.post("/products", form, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });
}
export function updateProduct({commit}, product) {
    const id = product.id
    if (product.images && product.images.length) {
      const form = new FormData();
      form.append('id', product.id);
      form.append('title', product.title);
      product.images.forEach(im => form.append(`images[${im.id}]`, im))
      if (product.deleted_images) {
        product.deleted_images.forEach(id => form.append('deleted_images[]', id))
      }
      for (let id in product.image_positions) {
        form.append(`image_positions[${id}]`, product.image_positions[id])
      }
      form.append('description', product.description || '');
      form.append('published', product.published ? 1 : 0);
      form.append('price', product.price);
      form.append('_method', 'PUT');
      product = form;
    } else {
      product._method = 'PUT'
    }
    return axiosClient.post(`/products/${id}`, product)
  }
// export function updateProduct({ commit }, product) {

//     const id = product.id;
//     let form = new FormData();
//     form.append("id", product.id);
//     form.append("published", product.published ? 1 : 0);

//     form.append("description", product.description);
//     form.append("price", product.price);
//     form.append("published", product.published ? 1 : 0);
//     product = form;
//     form.append("title", product.title);
//     form.append("description", product.description);
//      form.append("price", product.price);
//     // if (typeof product.price === 'number' && !isNaN(product.price)) {
//     //     form.append("price", product.price);
//     // } else {
//     //     console.error("Invalid price: must be a number.");
//     //     return Promise.reject("Invalid price: must be a number.");
//     // }

//     form.append("_method", "PUT");
//     if(product.deleted_images && product.deleted_images.length) {
//         product.deleted_images.forEach((im) => {
//             form.append("deleted_images[]", im);
//         });
//     }

//     if (product.images && product.images.length) {
//         product.images.forEach((im) => {
//             form.append("images[]", im);
//         });
//     }
//     // Append image only if it's a File instance and for once image
//     // if (product.image instanceof File) {
//     //     form.append("image", product.image);
//     // }

//     return axiosClient.post(`/products/${id}`, form, {
//         headers: { "Content-Type": "multipart/form-data" },
//     });
// }

export function deleteProduct({ commit }, id) {
    return axiosClient.delete(`/products/${id}`)
}

// Users Action
export function getUsers(
    { commit },
    { url = null, search = "", perPage, sort_field, sort_direction } = {}
) {
    commit("setUsers", [true]);
    url = url || "/users";
    return axiosClient
        .get(url, {
            params: {
                search: search,
                per_page: perPage,
                sort_field: sort_field,
                sort_direction: sort_direction,
            },
        })

        .then((res) => {
            commit("setUsers", [false, res.data]);
        })
        .catch(() => {
            commit("setUsers", [false]);
        });
    // .then(({data}) => {
    //       debugger;
    //     commit('setProducts', [false, data]);
    //     return data;
    // })
}

  export function createUser({commit}, user) {
    return axiosClient.post('/users', user)
  }

  export function updateUser({commit}, user) {
    return axiosClient.put(`/users/${user.id}`, user)
  }
  export function deleteUser({ commit }, id) {
    return axiosClient.delete(`/users/${id}`)
}


// Customers Action
export function getCustomers(
    { commit },
    { url = null, search = "", perPage, sort_field, sort_direction } = {}
) {
    commit("setCustomers", [true]);
    url = url || "/customers";
    return axiosClient
        .get(url, {
            params: {
                search: search,
                per_page: perPage,
                sort_field: sort_field,
                sort_direction: sort_direction,
            },
        })

        .then((res) => {
            commit("setCustomers", [false, res.data]);
        })
        .catch(() => {
            commit("setCustomers", [false]);
        });
}


  export function getCustomer({commit}, id) {
    return axiosClient.get(`/customers/${id}`)
  }

  export function createCustomer({commit}, customer) {
    return axiosClient.post('/customers', customer)
  }

  export function updateCustomer({commit}, customer) {
    return axiosClient.put(`/customers/${customer.id}`, customer)
  }
  export function deleteCustomer({ commit }, customer) {
    return axiosClient.delete(`/customers/${customer.id}`)

}

// Orders Action

export function getOrder({commit}, id) {
    return axiosClient.get(`/orders/${id}`)
  }


export function getOrders(
    { commit },
    { url = null, search = "", perPage, sort_field, sort_direction } = {}
) {
    debugger;
    commit("setOrders", [true]);
    url = url || "/orders";
    return axiosClient
        .get(url, {
            params: {
                search: search,
                per_page: perPage,
                sort_field: sort_field,
                sort_direction: sort_direction,
            },
        })

        .then((res) => {
            commit("setOrders", [false, res.data]);
        })
        .catch(() => {
            commit("setOrders", [false]);
        });
    // .then(({data}) => {
    //       debugger;
    //     commit('setProducts', [false, data]);
    //     return data;
    // })
}


// Categories Action

export function getCategories({commit, state}, {sort_field, sort_direction} = {}) {
    commit('setCategories', [true])
    return axiosClient.get('/categories', {
      params: {
        sort_field, sort_direction
      }
    })
      .then((response) => {
        commit('setCategories', [false, response.data])
      })
      .catch(() => {
        commit('setCategories', [false])
      })
  }

  export function createCategory({commit}, category) {
    return axiosClient.post('/categories', category)
  }

  export function updateCategory({commit}, category) {
    return axiosClient.put(`/categories/${category.id}`, category)
  }

  export function deleteCategory({ commit }, category) {
    return axiosClient.delete(`/categories/${category.id}`)
  }
