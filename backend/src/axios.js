import axios from 'axios'
import store from './store'
import router from './router'

const axiosClient = axios.create({
  baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`,
})

// axiosClient.interceptors.request.use(config => {
//     config.headers.Authorization = `Bearer ${store.state.user.token}`
//     return config;
//   }, function (error) {
//       // Do something with request error
//       return Promise.reject(error);
//     })

axiosClient.interceptors.request.use(
  (config) => {
    const token = store.state.user.token
    ;(console.log(token), 'token')

    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  function (error) {
    // Do something with request error
    return Promise.reject(error)
  }
)

axiosClient.interceptors.response.use(
  (response) => {
    return response
  },
  function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    if (error.response.status === 401) {
      sessionStorage.removeItem('TOKEN')
      router.push({ name: 'login' })
    }
    return Promise.reject(error)
  }
)

export default axiosClient
