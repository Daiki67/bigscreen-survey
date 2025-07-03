import axios from 'axios'
import { getAccessToken } from './utils.js'

let setLoading = null;

export function setGlobalLoadingSetter(fn) {
  setLoading = fn
}

// Création d'une instance Axios
const instance = axios.create({
  baseURL: 'http://localhost:8000/api', // récupère la base de l'Url
})

// Intercepteur pour afficher le loader avant chaque requête
instance.interceptors.request.use(
  config => {
    if (setLoading) setLoading(true)
    return config
  },
  error => {
    if (setLoading) setLoading(false)
    return Promise.reject(error)
  }
)

// Intercepteur pour masquer le loader après chaque réponse
instance.interceptors.response.use(
  response => {
    if (setLoading) setLoading(false)
    return response
  },
  error => {
    if (setLoading) setLoading(false)
    return Promise.reject(error)
  }
)

export default instance
