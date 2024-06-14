
import axiosClient from '../axios-client.js';


export const fetchClientProfiles = async () => {
  try {
    const response = await axiosClient.get('/account');
    console.log(response.data);
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const fetchClientProfile = async (clientId) => {
    try {
        const response = await axiosClient.get('/client/'.concat(clientId));

        return response.data;
    } catch (error) {
        throw error;
    }
};

export const updateClientProfile = async(formData) => {
  try {
    const response = await axiosClient.put('client',formData);
    return response.data;
  } catch (error) {
    throw error;
  }
};

export const deleteClientProfile = async (clientId) => {
    try {
        const response = await axiosClient.delete('/client/'.concat(clientId));
        return response.data;
    } catch (error) {
        throw error;
    }
};