// Import de l'instance Axios personnalisée
import axios from './axios.js';

/**
 * Enregistre le token d'accès dans le localStorage
 * @param {string} access_token - Le token d'accès à stocker
 * @returns {void}
 */
export const setAccessToken = (access_token)=> {
  return localStorage.setItem('access_token', access_token);
}

/**
 * Récupère le token d'accès depuis le localStorage
 * @returns {string|null} Le token d'accès ou null s'il n'existe pas
 */
export const getAccessToken = ()=> {
  return localStorage.getItem('access_token');
}

/**
 * Supprime le token d'accès du localStorage
 * @returns {void}
 */
export const removeAccessToken = ()=> {
  return localStorage.removeItem('access_token');
}

/**
 * Vérifie si l'utilisateur est authentifié (admin)
 * @returns {Promise<boolean>} true si authentifié, false sinon
 *
 * Utilise :
 *   - axios : pour faire une requête GET sur /admin/auth
 *   - getAccessToken : pour récupérer le token
 *   - removeAccessToken : pour supprimer le token si non valide
 */
export const isAuthenticated = async() => {
  try {
    const token = getAccessToken();
    if (!token || token === '' || token === undefined) {
      return false
    }
    const response = await axios.get('/admin/auth',{
      headers: { Authorization: 'Bearer ' + token }  // Ajoute le token dans l'en-tête Authorization
    });
    //console.log(response.data.authenticated);
    return true
  } catch (e) {
    console.error('Erreur lors de la récupération du user admin connecté: ', e);
    if(e.response && (e.response.status === 401 || e.response.status === 403)){
      removeAccessToken();
    }
    return false;
  }
}

/*
 * Librairies tierces utilisées :
 * - axios : client HTTP pour effectuer des requêtes AJAX (https://github.com/axios/axios)
 *   - axios.get(url, config) : effectue une requête GET avec configuration (headers, etc.)
 * - localStorage : API Web pour stocker des données côté client (clé/valeur)
 */

