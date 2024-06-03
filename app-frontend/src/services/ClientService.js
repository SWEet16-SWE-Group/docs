
import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api'; 

const apiService = axios.create({
  baseURL: API_BASE_URL,
});

export const fetchClientProfiles = async () => {
  try {
    const response = await apiService.get('/account');
    console.log(response.data);
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const fetchClientProfile = async (clientId) => {
    try {
        const response = await apiService.get('/client/'.concat(clientId));

        return response.data;
    } catch (error) {
        throw error;
    }
};

export const updateClientProfile = async(formData) => {
  try {
    const response = await apiService.put('client',formData);
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const deleteClientProfile = async (clientId) => {
    try {
        const response = await apiService.delete('/client/'.concat(clientId));
        return response.data;
    } catch (error) {
        throw error;
    }
};