import axios from './axios.js';

export const setUrlToken = (UrlToken) => {
  return localStorage.setItem('UrlToken', UrlToken)
}

export const getUrlToken = ()=> {
  return localStorage.getItem('UrlToken');
}

export const setAccessToken = (access_token)=> {
  return localStorage.setItem('access_token', access_token);
}

export const getAccessToken = ()=> {
  return localStorage.getItem('access_token');
}

export const removeAccessToken = ()=> {
  return localStorage.removeItem('access_token');
}


export const isAuthenticated = async() => {
  try {

    const token = getAccessToken();
    if (!token || token === '' || token === undefined) {
      return false
    }

    const response = await axios.get('/admin/auth',{
      headers: { Authorization: 'Bearer ' + token }  
    });
    console.log(response.data.authenticated);
    return true
  } catch (e) {
    console.error('Erreur lors de la récupération du user admin connecté: ', e);
    if(e.response && (e.response.status === 401 || e.response.status === 403)){
      removeAccessToken();
    }
    return false;
  }
}

