// Import de la librairie axios (client HTTP pour effectuer des requêtes AJAX)
import axios from 'axios'
// Import de la fonction utilitaire pour récupérer le token d'accès
import { getAccessToken } from './utils.js'

// Variable globale pour stocker la fonction de gestion du loader
let setLoading = null;

/**
 * Définit la fonction globale pour activer/désactiver le loader
 * @param {function} fn - Fonction qui prend un booléen (true/false) pour afficher ou masquer le loader
 */
export function setGlobalLoadingSetter(fn) {
  setLoading = fn
}

// Création d'une instance Axios personnalisée
// Nom : instance
// Type : AxiosInstance
// Paramètres :
//   - baseURL : string (URL de base de l'API)
const instance = axios.create({
  baseURL: 'http://localhost:8000/api', // récupère la base de l'Url
})

// Intercepteur de requête : affiche le loader avant chaque requête
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

// Intercepteur de réponse : masque le loader après chaque réponse
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

// Exporte l'instance Axios personnalisée pour l'utiliser dans toute l'application
export default instance

/*
 * Librairies tierces utilisées :
 * - axios : client HTTP pour effectuer des requêtes AJAX (https://github.com/axios/axios)
 *   - axios.create({ baseURL }) : crée une instance personnalisée avec une URL de base
 *   - instance.interceptors.request/response : permet d'intercepter et de modifier les requêtes/réponses globalement
 */
