import axios from "axios";

const api = axios.create({
  //URL de mon backend
  baseURL: "http://localhost:8000/api",
});

// Intercepteur pour ajouter le token JWT
api.interceptors.request.use((config) => {

  //permet de faire la même chose que dans le backend avec authorize
  const token = localStorage.getItem("token");
  if (token) config.headers.Authorization = `Bearer ${token}`;
  return config;
});

export default api;

